@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-8">
            <span>                 
                @if (session('alert'))
                <div class="alert alert-info">
                    {{ session('alert') }}
                </div>
                @endif
                
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </span>
            <div class="card">
                <div class="card-header">Tarefas</div>
                
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#add-task">Nov Tarefa</button>
                    
                    <table class="table border='1' text-center">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Descrção</th>
                                <th scope="col">Atualização</th>
                                <th scope="col">Finalizada</th>
                                <th scope="col">Projeto</th>
                                <th colspan="3" scope="col">Açoes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                            <tr scope="row">
                                <td scope="col">{{ $task->id }}</td>
                                <td scope="col">{{ $task->description }}</td>
                                <td scope="col">{{ $task->created_at }}</td>
                                <td scope="col">@if ($task->concluded == 1) Sim @else Não @endif</td>
                                <td scope="col">{{ $task->project_id }}</td>
                                <td scope="col">
                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#edit-task" onclick="setValueModal({{ $task->id }})" >Editar</a>
                                </td>
                                <td scope="col">
                                    <a href="#" onclick="getTask({{$task->id}})" class="badge badge-info" data-toggle="modal" data-target="#delete-task">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Adicionar -->
<div class="modal fade" id="add-task" tabindex="-1" role="dialog" aria-labelledby="add-taskLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-taskLabel">Nova Tarefa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="add-task" method="POST" action="{{ route('task.store') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <input type="text" class="form-control" name="description" id="description"
                        aria-describedby="nome" placeholder="Digite a descição da tarefa...">
                    </div>
                    <div class="form-group">
                        <div>
                            <p>{{$project->name}}</p>
                        </div>
                        <input type="hidden" name="project_id" value="{{$project->id}}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button  type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal editar -->
<div class="modal fade" id="edit-task" tabindex="-1" role="dialog" aria-labelledby="edit-taskLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-taskLabel">Editar Tarefa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="edit-task" id="edit-task-form" method="POST" action="">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <input type="text" class="form-control" name="description" id="description-edit"
                        aria-describedby="nome" placeholder="Digite a descrição da tarefa...">
                    </div>
                    <div class="form-group">Concluido</label>
                        <input type="checkbox" class="form-control" value="1" name="concluded" id="concluded"
                        aria-describedby="concluido">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button  type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal excluir -->
<div class="modal" id="delete-task" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deletar Tarefa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Realmente deseja deletear esta tarefa?</p>
                <div id="task-show"></div>
            </div>
            <div class="modal-footer">
                <form id="delete-task-form" method="POST" action="">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="submit" id="btn-delete" class="btn btn-primary">Delete</button>
                </form>
                <a href="#" type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</a>
            </div>
        </div>
    </div>
</div>

<script>    
    function setValueModal (id) {
        axios.get('../task/' + id)
        .then(function(response){
            document.querySelector('#description-edit').value = response.data.description;
            if (response.data.concluded) {
                document.querySelector('#concluded').checked = true;
            }
            document.querySelector('#edit-task-form').action = '../task/' + id;
        });  
        
    }
    
    function getTask (id) {
        axios.get('../task/' + id)
        .then(function(response){
            let concluded = response.data.concluded? "Sim" : "Não";
            document.querySelector('#task-show').innerHTML = "Descrição: " + response.data.description + "<br>"+
            "Concluido: " + concluded;
            document.querySelector('#delete-task-form').action = '../task/' + id;
        });  
    }
    
    
    
</script>

@endsection