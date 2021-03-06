{% import "manage/macros.tpl" as macros %}

{% extends "manage/wrapper.tpl" %}

{% block heading %}{% trans "Board Management" %}{% endblock %}

{% block managecontent %}

<form action="{{ base_url }}app=board&amp;module=board&amp;do=board&amp;action=post" method="post">
  {{ macros.manageform("boards", "Add Board", true,
                       { 'Board Name' : { 'id' : 'name', 'type' : 'text', 'desc' : "The directory of the board. <b>Only put in the letter(s) of the board directory, no slashes!</b>
",  'value' : entry.entry_name } ,
                         'Board Description'    : { 'id' : 'description', 'type' : 'text', 'desc' : "The name of the board", 'value' : entry.entry_description } ,
                         'First Post ID'  : { 'id' : 'start', 'type' : 'text', 'desc' : "The first post of this board will recieve this ID.",  'value' : entry.entry_start } }
                       ) 
  }}
<input type="hidden" id="del" name="del" value="{{ entry.entry_id }}" />
<input type="hidden" name="directory" id="directory" value="" />
</form>
<br />
    <fieldset id="edit-boards">
      <legend>{% trans 'Edit Boards' %}</legend>
	  <table class="stats">
	    <col class="col1" /><col class="col2" /><col class="col2" />
	    <tr>
		  <th colspan="2">{% trans 'Board ID' %}</th>
		  <th>{% trans 'Description' %}</th>
		</tr>
        {% for id, name in entries %}
        <tr>
		  <td>
			<a href="{{ base_url }}app=board&amp;module=board&amp;section=boardopts&amp;do=edit&amp;board={{ id }}">
			  <img src="{% kxEnv "paths:boards:path" %}/public/manage/edit.png" width="16" height="16" alt="Edit" />
			</a>
			<a href="{{ base_url }}app=board&amp;module=board&amp;section=board&amp;do=del&amp;board={{ id }}">
			  <img src="{% kxEnv "paths:boards:path" %}/public/manage/delete.png" width="16" height="16" alt="Delete" />
			</a>
			<a href="{{ base_url }}app=board&amp;module=board&amp;section=board&amp;action=regen&amp;board={{ id }}">
			  <img src="{% kxEnv "paths:boards:path" %}/public/manage/rebuild.png" width="16" height="16" alt="Regenerate" />
			</a>
		  </td>
		  <td>
		    <a href="{% kxEnv "paths:boards:path" %}/{{ id }}/">/{{id}}/</a>
		  </td>
		  <td>
		    {{ name }}
		  </td>
		</tr>
        {% endfor %}
	  </table>
    </fieldset>
{% endblock %}
