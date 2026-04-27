@extends('layouts.app')

@section('title', __('page.document_show.page_title', ['id' => $document->id, 'name' => config('app.name')]))

@section('content')
@include('documents.partials.show-body', ['document' => $document])
@endsection
