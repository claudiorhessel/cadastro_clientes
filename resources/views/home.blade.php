@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if($route == 'home')
                    <h3>Consulta de Clientes</h3>
                    @endif

                    @if($route == 'customerEdit')
                    <h3>Editar Cliente</h3>
                    @endif

                    @if($route == 'customerInsert')
                    <h3>Cadastrar Cliente</h3>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div>{{$error}}</div>
                        @endforeach
                    @endif

                    <div class="container mt-2">
                        <div class="card mb-2">
                            <div class="container mt-2 pb-2">
                                <form id="customer_form" name="customer_form" class="row g-3" method="{{ $method }}" action="{{ route($route) }}">
                                    @csrf
                                    <input type="hidden" id="id" name="id" value="{{ $id }}">
                                    <div class="col-md-6">
                                        <label for="cpf" class="form-label">CPF:</label>
                                        <input
                                            type="text"
                                            class="form-control @error('cpf') is-invalid @enderror"
                                            id="cpf"
                                            name="cpf"
                                            data-mask="999.999.999-99"
                                            value="{{ isset($currentCustomer['cpf'])? $currentCustomer['cpf'] : '' }}"
                                            {{ $route != "home"? "required" : "" }}
                                        >
                                        @error('cpf')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="birtdate" class="form-label">Data Nascimento:</label>
                                        <input
                                            type="date"
                                            class="form-control @error('birtdate') is-invalid @enderror"
                                            id="birtdate"
                                            name="birtdate"
                                            value="{{ isset($currentCustomer['birtdate'])? $currentCustomer['birtdate'] : '' }}"
                                            {{ $route != "home"? "required" : "" }}
                                        >
                                        @error('birtdate')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-8">
                                        <label for="full_name" class="form-label">Nome:</label>
                                        <input
                                            type="text"
                                            class="form-control @error('full_name') is-invalid @enderror"
                                            id="full_name"
                                            name="full_name"
                                            value="{{ isset($currentCustomer['full_name'])? $currentCustomer['full_name'] : '' }}"
                                            {{ $route != "home"? "required" : "" }}
                                        >
                                        @error('full_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="gender_m" class="form-label">Sexo:</label>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input @error('gender') is-invalid @enderror"
                                                type="radio"
                                                name="gender"
                                                id="gender_m"
                                                value="M" {{ isset($currentCustomer['gender']) && $currentCustomer['gender'] == "M"? "checked" : '' }}
                                                {{ $route != "home"? "required" : "" }}
                                            >
                                            <label class="form-check-label" for="gender_m" >
                                                M
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input @error('gender') is-invalid @enderror"
                                                type="radio"
                                                name="gender"
                                                id="gender_f"
                                                value="F"
                                                {{ isset($currentCustomer['gender']) && $currentCustomer['gender'] == "F"? "checked" : '' }}
                                                {{ $route != "home"? "required" : "" }}
                                            >
                                            <label class="form-check-label" for="gender_f">
                                                F
                                            </label>
                                        </div>
                                        @error('gender')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="address" class="form-label">Endereço:</label>
                                        <input
                                            type="text"
                                            class="form-control @error('address') is-invalid @enderror"
                                            id="address"
                                            name="address"
                                            value="{{ isset($currentCustomer['address'])? $currentCustomer['address'] : '' }}"
                                            {{ $route != "home"? "required" : "" }}
                                        >
                                        @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="state" class="form-label">Estado:</label>
                                        <select
                                            class="form-select @error('state_id') is-invalid @enderror"
                                            aria-label=""
                                            id="state_id"
                                            name="state_id"
                                            {{ $route != "home"? "required" : "" }}
                                        >
                                            <option value="">Selecione um Estado</option>
                                            @foreach($state as $key => $stateData)
                                            <option {{ isset($currentCustomer['state_id']) && $currentCustomer['state_id'] == $stateData['id']? "selected" : '' }} value="{{ $stateData['id'] }}">{{ $stateData['name'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('state_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="city" class="form-label">Cidade:</label>
                                        <select
                                            class="form-select @error('city_id') is-invalid @enderror"
                                            aria-label=""
                                            id="city_id"
                                            name="city_id"
                                            {{ $route != "home"? "required" : "" }}
                                        >
                                            <option value="">Selecione uma Cidade</option>
                                            @foreach($city as $key => $cityData)
                                            <option {{ isset($currentCustomer['city_id']) && $currentCustomer['city_id'] == $cityData['id']? "selected" : '' }} value="{{ $cityData['id'] }}">{{ $cityData['name'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        @if($route == 'home')
                                            <button type="submit" class="btn btn-info">Pesquisar</button>
                                            <a
                                                href="{{ route("home", ["method" => "POST", "route" => "customerInsert"]) }}"
                                                class="edit btn btn-primary"
                                            >Cadastrar</a>
                                            <a
                                                href="{{ route("home") }}"
                                                class="edit btn btn-danger"
                                            >Limpar</a>
                                        @endif
                                        @if($route == 'customerEdit' || $route == 'customerInsert')
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                            <a
                                                href="{{ route("home") }}"
                                                class="edit btn btn-secondary"
                                            >Cancelar</a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="container mt-2">
                                <table class="table table-bordered mb-2">
                                    <thead>
                                        <tr class="table-success">
                                            <th scope="col">Ações</th>
                                            <th scope="col">CPF</th>
                                            <th scope="col">Nome Completo</th>
                                            <th scope="col">Data de Nascimento</th>
                                            <th scope="col">Sexo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $customer)
                                        <tr>
                                            <td>
                                                <a
                                                    href="{{ route("home", ["id" => $customer['id'], "method" => "POST", "route" => "customerEdit"]) }}"
                                                    class="edit btn btn-success {{ $route != 'home'? 'disabled' : '' }}"
                                                >Edit</a>
                                                <a
                                                    href="{{ route("customerRemove", ["id" => $customer['id']]) }}"
                                                    class="edit btn btn-danger {{ $route != 'home'? 'disabled' : '' }}"
                                                >Remove</a>
                                            </td>
                                            <td>{{ $customer['cpf'] }}</td>
                                            <td>{{ $customer['full_name'] }}</td>
                                            <td>{{ $customer['birtdate'] }}</td>
                                            <td>{{ $customer['gender'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        @foreach($links as $key => $pagination)
                                        @if($key == 0)
                                        <li
                                            class="page-item {{ ($current_page == 1 || $route != 'home')? 'disabled' : '' }}"
                                        >
                                            <a
                                                class="page-link"
                                                href="{{ route("home", ["page" => $current_page - 1]) }}"
                                            >Anterior</a>
                                        </li>
                                        @continue
                                        @endif
                                        @if(($key - 1) == $last_page)
                                        <li
                                            class="page-item {{ ($current_page == $last_page || $route != 'home')? 'disabled' : '' }}"
                                        >
                                            <a
                                                class="page-link"
                                                href="{{ route("home", ["page" => $current_page + 1]) }}"
                                            >Próxima</a>
                                        </li>
                                        @continue
                                        @endif
                                        <li class="page-item">
                                            <a
                                                class="
                                                    page-link
                                                    {{ $current_page == $key ? 'active' : ''}}
                                                    {{ $route != 'home'? 'disabled' : '' }}"
                                                href="{{ route("home", ["page" => $pagination["label"]]) }}"
                                            >{{ $pagination["label"] }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
