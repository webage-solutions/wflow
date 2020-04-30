<?php

namespace App\Models;

use App\Components\CustomFields\CustomFieldBag;
use App\Components\ExpressionLanguage\Bundles\TaskTransitionConditionVariableBundle;
use App\Components\Search\Searchable;
use App\Exceptions\StateNotFoundException;
use App\Exceptions\TransitionNotAllowedException;
use App\Scopes\CurrentOrganizationScope;
use App\Objects\Transition;
use Carbon\Carbon;
use CustomFields;
use Eloquent;
use Exception;
use ExpressionLanguage;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * @package App\Models
 * @mixin Eloquent
 * @property int id
 * @property int organization_id
 * @property int task_type_id
 * @property int current_state_id
 * @property int code
 * @property string title
 * @property string description
 * @property array history
 * @property CustomFieldBag fields
 * @property State current_state
 * @property TaskType task_type
 * @property Transition[] transitions
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 */
class Task extends Model
{

    use ScopedTrait, Searchable;

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'state_slug' => $this->current_state->slug,
            'state_name' => $this->current_state->name,
            'state_description' => $this->current_state->description,
        ];
    }

    protected static $scopes = [
        CurrentOrganizationScope::class
    ];

    protected $casts = [
        'history' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $hidden = [ 'history', 'scalar_fields'];

    protected $appends = ['code', 'transitions', 'fields'];

    public function current_state()
    {
        return $this->belongsTo(State::class, 'current_state_id');
    }

    public function task_type()
    {
        return $this->belongsTo(TaskType::class);
    }

    public function getCodeAttribute()
    {
        return strtoupper($this->task_type->slug) . '-' . $this->attributes['code'];
    }

    /**
     * Return the currently available transitions for this task
     * @return array
     * @throws Exception
     */
    public function getTransitionsAttribute()
    {

        // TODO - cache this!

        // filter the available transitions
        $transitions = array_filter($this->task_type->active_workflow->transitions, function(Transition $item) {

            // skip transitions that don't have the current from-state (or the _all wildcard)
            if ($item->from !== '_all' && $item->from !== $this->current_state->slug) {
                return false;
            }

            // empty conditions are always accepted
            if (!$item->condition) {
                return true;
            }

            // filter the transitions where the condition passes
            $variableBundle = new TaskTransitionConditionVariableBundle($this);
            return $item->condition === null || ExpressionLanguage::evaluate($item->condition, $variableBundle);

        });

        // go through all the available transitions
        $output = [];
        foreach ($transitions as $transition) {

            // replace the _all wildcard on from-state with the current state
            if ($transition->from === '_all') {
                $transition->from = $this->current_state->slug;
            }

            // explode the _all wildcard on to-state to all available states
            if ($transition->to === '_all') {
                foreach ($this->task_type->states as $state) {

                    // skip the current state
                    if ($transition->from === $state->slug) {
                        continue;
                    }

                    // include all the others
                    $output[] = new Transition([
                        'from' => $transition->from,
                        'to' => $state->slug,
                        'slug' => "to-{$state->slug}",
                        'name' => "To {$state->name}",
                    ]);
                }
                continue;
            }

            // no wildcard, just include the transition as it is
            $output[] = $transition;
        }

        // return ignoring the keys
        return array_values($output);
    }

    public function getFieldsAttribute()
    {
        $values = json_decode($this->attributes['fields'], true);
        $fieldsArray = CustomFields::parseFields($this->task_type->fields, $values);
        return new CustomFieldBag($fieldsArray);
    }

    public function getScalarFieldsAttribute()
    {
        $values = json_decode($this->attributes['fields'], true);
        $fieldsArray = CustomFields::parseScalarFields($this->task_type->fields, $values);
        return new CustomFieldBag($fieldsArray);
    }

    /**
     * @param string $transition the transition slug
     * @return bool
     */
    public function can(string $transition): bool
    {
        return array_reduce($this->transitions, function ($carry, Transition $current) use ($transition) {
            return $carry || $current->slug === $transition;
        }, false);
    }

    /**
     * @param string $transitionSlug
     * @throws StateNotFoundException
     * @throws TransitionNotAllowedException
     */
    public function execute(string $transitionSlug): void
    {
        // go through the available transitions
        foreach ($this->transitions as $transition) {
            if ($transition->slug === $transitionSlug) {



                $state = State::where('slug', $transition->to)->first();

                if ($state === null) {
                    throw new StateNotFoundException();
                }

                // TODO - Transaction and save history
                $this->current_state_id = $state->id;
                $this->save();
                return;
            }
        }

        throw new TransitionNotAllowedException();
    }

}
