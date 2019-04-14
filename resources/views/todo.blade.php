
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       <div class="col-md-12"> 
            <div class="card">
                <div class="card-header">Todos</div>

                <table class="todo-table"> 
                @if($task->total()!=0)
                    @foreach($task as $item)
                    <tr class='tr-task' data-id="{{$item['id']}}">
                        <td>
                            <input type="checkbox" class="todo-task" name="task-status" value={{$item->id}} <?php echo ($item->status=='1')?'checked':''?>><label>{{ucfirst($item->task)}}</label>
                            @foreach($item->category as $row)
                                    <label class="cat-label">{{ucfirst($row->name)}}</label>
                            @endforeach
                            <button type="button" class="close delete-task" data-id="{{$item->id}}" aria-label="Close" data-url='tasks/{{$item->id}}' onclick="return confirm('You want to delete?');">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </td>
                    </tr>

                    @endforeach
                    </table>

                    <div class="paginate">
                        {{ $task->links() }}
                    </div>  
                @else
                <div class="alert alert-success">
                                <strong>You have not Task yet!</strong>
                </div>
                @endif    
                            <button type="button" class="btn btn-info btn-lg taskmodal-btn" data-toggle="modal" data-target="#taskmodal">+ Add Task</button>
                    
                    <div id="taskmodal" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Add Task</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                          </div>
                          <div class="modal-body">
                            <span class="error-fields" style="display: none; color: red;"></span>

                            <input type="text" name="task" class="task form-control" required placeholder="Add task">
                            <br>
                            <select class="form-control task-cat" multiple required>
                                @foreach($category as $item)
                                    <option value="{{$item->id}}">{{ucfirst($item->name)}}
                                    </option>
                                @endforeach
                            </select>

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary add-task">Submit</button>
                          </div>
                        </div>

                      </div>
                    </div>
                             
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
                $(document).on("click",".taskmodal-btn",function(e) {
                    $('.error-fields').css({'display':'none'});
                });
                $(document).on("click",".add-task",function(e) {

                    
                    if(($('.task').val() == '') || ($('.task-cat').val() == '') ){
                        $('.error-fields').html('FIll in all input fields');
                        $('.error-fields').css({'display':'block'});
                      }
            else{
                e.preventDefault();
                
                $.ajax({ 

                        url: "{{route('tasks.store')}}",
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            name: $('.task').val(),
                            category: $('.task-cat').val()
                        },
                        success: function(result) {
                            $('#taskmodal').modal('toggle');
                            location.reload();
                        }
                });
            }   
        });
        $(document).on("click",".delete-task",function(e) {
            // var temp = $(this).parents().find('.tr-task');
            url = $(this).attr("data-url")
            $(this).closest ('tr').remove ();
            var temp = $(this).attr("data-id");
            $.ajax({ 

                    url: url,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: temp,
                    },
                    success: function(result) {
                        alert('Task deleted successfully');
                    }
            });

        });
        $(document).on("click",".todo-task",function(e) {
           
            var temp = $(this).val();
            $.ajax({ 

                    url: "{{route('update-task')}}",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: temp,
                    },
                    success: function(result) {
                        alert('Task status updated successfully');
                    }
            });

        });
    });    

</script>
@endsection