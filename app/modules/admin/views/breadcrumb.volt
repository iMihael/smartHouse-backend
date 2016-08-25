<ol class="breadcrumb">
    {% for link in links %}
        <li><a href="{{ link['path'] }}">{{ link['label'] }}</a></li>
    {% endfor %}
    <li class="active">{{ active }}</li>
</ol>