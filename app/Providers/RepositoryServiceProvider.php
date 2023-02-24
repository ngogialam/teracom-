<?php

namespace App\Providers;

use App\Repositories\Eloquents\FileAttachmentRepositoryEloquent;
use App\Repositories\Eloquents\ApprovalProcessRepositoryEloquent;
use App\Repositories\Eloquents\ProcessChangeLogEloquent;
use App\Repositories\Eloquents\ProcessRepositoryEloquent;
use App\Repositories\Eloquents\ProcessStepRepositoryEloquent;
use App\Repositories\Eloquents\StepCheckListRepositoryEloquent;
use App\Repositories\Eloquents\StepGroupConditionRepositoryEloquent;
use App\Repositories\Eloquents\StepObjectRepositoryEloquent;
use App\Repositories\Eloquents\StepTransferConditionRepositoryEloquent as STCRepositoryEloquent;
use App\Repositories\Eloquents\TaskEvaluateRepositoryEloquent;
use App\Repositories\Eloquents\TaskObjectRepositoryEloquent;
use App\Repositories\Eloquents\TaskRepositoryEloquent;
use App\Repositories\Eloquents\TaskTimesheetRepositoryEloquent;
use Illuminate\Support\ServiceProvider;
use App\Repositories\TicketApprovalLogRepositoryInterface;
use App\Repositories\Eloquents\TicketApprovalLogRepositoryEloquent;
use App\Repositories\Eloquents\TicketHistoryRepositoryEloquent;
use App\Repositories\Eloquents\TicketRequestRepositoryEloquent;
use App\Repositories\FileAttachmentRepositoryInterface;
use App\Repositories\ApprovalProcessRepositoryInterface;
use App\Repositories\Eloquents\ProcessCommentsRepositoryEloquent;
use App\Repositories\ProcessChangeLogRepositoryInterface;
use App\Repositories\ProcessCommentsRepositoryInterface;
use App\Repositories\ProcessRepositoryInterface;
use App\Repositories\ProcessStepRepositoryInterface;
use App\Repositories\StepCheckListRepositoryInterface;
use App\Repositories\StepGroupConditionRepositoryInterface;
use App\Repositories\StepObjectRepositoryInterface;
use App\Repositories\StepTransferConditionRepositoryInterface as STCRepositoryInterface;
use App\Repositories\TaskEvaluateRepositoryInterface;
use App\Repositories\TaskObjectRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use App\Repositories\TaskTimesheetRepositoryInterface;
use App\Repositories\TicketHistoryRepositoryInterface;
use App\Repositories\TicketRequestRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ProcessRepositoryInterface::class, ProcessRepositoryEloquent::class);
        $this->app->bind(ProcessStepRepositoryInterface::class, ProcessStepRepositoryEloquent::class);
        $this->app->bind(ProcessChangeLogRepositoryInterface::class, ProcessChangeLogEloquent::class);
        $this->app->bind(StepCheckListRepositoryInterface::class, StepCheckListRepositoryEloquent::class);
        $this->app->bind(ApprovalProcessRepositoryInterface::class, ApprovalProcessRepositoryEloquent::class);
        $this->app->bind(FileAttachmentRepositoryInterface::class, FileAttachmentRepositoryEloquent::class);
        $this->app->bind(STCRepositoryInterface::class, STCRepositoryEloquent::class);
        $this->app->bind(StepGroupConditionRepositoryInterface::class, StepGroupConditionRepositoryEloquent::class);
        $this->app->bind(StepObjectRepositoryInterface::class, StepObjectRepositoryEloquent::class);
        $this->app->bind(TicketHistoryRepositoryInterface::class, TicketHistoryRepositoryEloquent::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepositoryEloquent::class);
        $this->app->bind(TicketRequestRepositoryInterface::class, TicketRequestRepositoryEloquent::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepositoryEloquent::class);
        $this->app->bind(TaskTimesheetRepositoryInterface::class, TaskTimesheetRepositoryEloquent::class);
        $this->app->bind(TicketApprovalLogRepositoryInterface::class, TicketApprovalLogRepositoryEloquent::class);
        $this->app->bind(TaskObjectRepositoryInterface::class, TaskObjectRepositoryEloquent::class);
        $this->app->bind(TaskEvaluateRepositoryInterface::class, TaskEvaluateRepositoryEloquent::class);
        $this->app->bind(ProcessCommentsRepositoryInterface::class, ProcessCommentsRepositoryEloquent::class);
    }
}
