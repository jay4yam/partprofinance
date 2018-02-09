<!-- TO DO List -->
<div class="box box-primary">
    <div class="box-header">
        <i class="ion ion-clipboard"></i>

        <h3 class="box-title">Tâches & Rdv</h3>

        <div class="box-tools pull-right">
            <ul class="pagination pagination-sm inline withoutmargin">
                {{ $tasks->links() }}
            </ul>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
        <ul class="todo-list">
            @foreach($tasks as $task)
            <li class="{{ $task->status == 0 ? 'done' : '' }}">
                <!-- drag handle -->
                <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                <!-- checkbox -->
                <input type="checkbox" value="{{ $task->status }}" class="taskdone" data-taskid="{{ $task->id }}" title="done" {{ $task->status == 0 ? 'checked' :'' }}>
                <!-- todo text -->
                <span class="text">{{ $task->taskcontent }} | {{ $task->user->prospect->nom }}</span>
                <!-- Emphasis label -->
                <small class="label level-{{ $task->level ? str_slug($task->level) : 'default' }} pull-right"><i class="fa fa-clock-o"></i> {{ $task->taskdate->format('d M Y') }}</small>
                <!-- General tools such as edit or delete-->
                <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix no-border">
        <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
    </div>
</div>
<!-- /.box -->