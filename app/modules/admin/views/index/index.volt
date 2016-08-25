{% extends 'layout.volt' %}

{% block title %}Admin Panel{% endblock %}

{% block body %}
    <h2>Admin Panel</h2>
    <ul class="list-group">
        <li class="list-group-item">
            <a href="{{ url('admin/module-category/list') }}">Module Categories</a>
        </li>
        <li class="list-group-item">Module Types</li>
    </ul>
{% endblock %}