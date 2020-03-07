<?php

namespace App\Models;

use App\Scopes\LoggedOrganizationScope;
use App\Components\ExpressionLanguage\Bundles\ActiveWorkFlowForTaskTypeVariableBundle;
use App\Components\ExpressionLanguage\Facades\ExpressionLanguage;
use App\ValueObjects\CustomFieldSchema;
use App\ValueObjects\CustomTypeSchema;
use App\ValueObjects\WorkFlow;
use Illuminate\Database\Eloquent\Collection;

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
class TaskType extends AbstractScopedModel
{

    protected static $scopes = [
        LoggedOrganizationScope::class
    ];


    protected $appends = ['active_workflow'];

    protected $hidden = ['fields', 'workflows'];

    public function getFieldsAttribute()
    {
        return array_map(function ($item) {
            return new CustomFieldSchema($item);
        }, json_decode($this->attributes['fields'], true));
    }

    public function getWorkflowsAttribute()
    {
        return array_map(function ($item) {
            return new WorkFlow($item);
        }, json_decode($this->attributes['workflows'], true));
    }

    /**
     * @param WorkFlow[] $workflows
     */
    public function setWorkflowsAttribute(array $workflows)
    {

    }

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
