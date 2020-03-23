@php

use App\Models\Organization;

/**
 * @var Organization[] $organizations
 */

@endphp

@extends('layouts.full')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Select Organization</h2></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul>
                        @foreach($organizations as $organization)
                        <li class="my-2">
                            <a href="{{ uiRoute($organization->main_domain) }}">
{{--                                <img :src="organization.logo" class="organization-logo-img" :alt="organization.name" :title="organization.name" v-if="organization.logo"/>--}}
                                <span>{{ $organization->name }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <hr/>
                    <a><span class="fa fa-building"></span> Manage Organizations</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
