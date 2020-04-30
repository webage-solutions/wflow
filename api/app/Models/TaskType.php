<?php

namespace App\Models;

use App\Casts\CustomFieldsSchemaCast;
use App\Casts\WorkflowsCast;
use App\Components\Search\Searchable;
use App\Scopes\CurrentOrganizationScope;
use App\Components\ExpressionLanguage\Bundles\ActiveWorkFlowForTaskTypeVariableBundle;
use App\Components\ExpressionLanguage\Facades\ExpressionLanguage;
use App\Objects\CustomFieldSchema;
use App\Objects\WorkFlow;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TaskType
 * @package App\Models
 * @mixin \Eloquent
 * @property int id
 * @property int organization_id
 * @property string slug
 * @property string name
 * @property string description
 * @property CustomFieldSchema[] fields
 * @property WorkFlow[] workflows
 * @property WorkFlow active_workflow
 * @property Collection|State[] $states
 */
class TaskType extends Model
{

    use ScopedTrait, Searchable;

    public function toSearchableArray()
    {
        return [
            'name' => $this->name
        ];
    }

    protected static $scopes = [
        CurrentOrganizationScope::class
    ];


    protected $appends = ['active_workflow'];

    protected $hidden = ['organization_id', 'fields', 'workflows'];

    protected $casts = [
        'workflows' => WorkflowsCast::class,
        'fields' => CustomFieldsSchemaCast::class,
    ];

    public function getActiveWorkflowAttribute()
    {
        foreach ($this->workflows as $workflow) {
            if (ExpressionLanguage::evaluate($workflow->when, new ActiveWorkFlowForTaskTypeVariableBundle())) {
                return $workflow;
            }
        }
        return null;
    }

    public function states()
    {
        return $this->belongsToMany(State::class);
    }
}
