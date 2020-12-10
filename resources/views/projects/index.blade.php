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
                <div class="card-header">Projetos</div>
                
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#add-project">Novo Projeto</button>
                    
                    <table class="table border='1' text-center">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Atualização</th>
                                <th scope="col">Finalizada</th>
                                <th colspan="2" scope="col">Açoes</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @if(isset($projects))
                            @foreach ($projects as $project)
                            <tr scope="row">
                                <td scope="col">{{ $project->id }}</td>
                                <td scope="col">{{ $project->name }}</td>
                                <td scope="col">{{ $project->created_at->format('d/m/Y') }}</td>
                                <td scope="col">@if ($project->concluded == 1) Sim @else Não @endif</td>
                                <td scope="col">
                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#edit-project" onclick="setValueModal({{ $project->id }})" >Editar</a>
                                </td>
                                <td scope="col">
                                    <a class="badge badge-info" href="{{ route('taskList', $project->id) }}">Tarefas</a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Adicionar -->
<div class="modal fade" id="add-project" tabindex="-1" role="dialog" aria-labelledby="add-projectLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-projectLabel">Adicionar Projeto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="add-project" method="POST" action="{{ route('project.store') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Nome do projeto</label>
                        <input type="text" class="form-control" name="name" id="name"
                        aria-describedby="nome" placeholder="Digite o nome do seu projeto...">
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
<div class="modal fade" id="edit-project" tabindex="-1" role="dialog" aria-labelledby="edit-projectLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-projectLabel">Editar Projeto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-project-form" method="POST" action="">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Nome do projeto</label>
                        <input type="text" class="form-control" value="" name="name" id="name-edit"
                        aria-describedby="nome" placeholder="Digite o nome do seu projeto...">
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
<div class="modal fade" id="destroy-project" tabindex="-1" role="dialog" aria-labelledby="destroy-projectLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="destroy-projectLabel">Excluir Projeto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="edit-project" method="POST" action="{{ route('project.update', $project->id) }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Nome do projeto</label>
                        <input type="text" class="form-control" value="" name="name" id="name-edit"
                        aria-describedby="nome" placeholder="Digite o nome do seu projeto...">
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

<script>    
    function setValueModal (id) {
        
        axios.get('project/' + id)
        .then(function(response){
            document.querySelector('#name-edit').value = response.data.name;
            if (response.data.concluded) {
                document.querySelector('#concluded').checked = true;
            }
            document.querySelector('#edit-project-form').action = 'project/' + id;
        });  
    }
</script>

@endsection