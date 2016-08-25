{% extends 'layout.volt' %}

{% block title %}Module Categories - List{% endblock %}

{% block body %}

    {{ partial("breadcrumb", [
        'links': [
            ['path': url('admin'), 'label': 'Admin Panel']
        ],
        'active': 'Module Categories'
    ]) }}

    <h2>Module Categories</h2>

    <a class="btn btn-primary" href="{{ url('admin/module-category/create') }}">Create Category</a>

{% endblock %}