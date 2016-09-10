{% extends 'layout.volt' %}

{% block title %}
    Smart House - SignUp Page
{% endblock %}

{% block body %}
    <div class="col-lg-offset-3 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>SignUp</h2>
            </div>
            <div class="panel-body">

                {% if errors %}
                    <div class="alert alert-danger">
                    {% for error in errors %}
                        <p>{{ error }}</p>
                    {% endfor %}
                    </div>
                {% endif %}

                <form method="POST">
                    {% autoescape false %}
                    <div class="form-group">
                        <label>First Name</label>
                        {{ form.render('first_name', ['class' : 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        {{ form.render('last_name', ['class' : 'form-control']) }}
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        {{ form.render('email', ['class' : 'form-control']) }}
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        {{ form.render('password', ['class' : 'form-control']) }}
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        {{ form.render('password_confirm', ['class' : 'form-control']) }}
                    </div>

                    <div class="form-group">
                        <input type="submit" value="SignUp" class="btn btn-primary" />
                    </div>
                    {% endautoescape %}
                </form>
            </div>
        </div>
    </div>
{% endblock %}
