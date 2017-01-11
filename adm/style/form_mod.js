/******
* This is a collection of scripts written for Form Mod (Form Creator)
*****/

// Show/Hide element with cookie option

/***
*	takes three possible elements...
*	switches the first element and set cookie
*	switch second element visibility...
*
***/

jQuery(window).load(function(){
	jQuery('#dvLoading').fadeOut(1500);
});

function update_form()
{
	document.getElementById('update_button').click();
}

function Show(id)
{
	var element = null;
	if (document.getElementById)
	{
		element = document.getElementById(id);
	}
	else if (document.all)
	{
		element = document.all[id];
	}
	else if (document.layers)
	{
		element = document.layers[id];
	}
	if (element.style.display == "none")
	{
		element.style.display = "inline";
	}
	else
	{
		element.style.display = "none";
	}
}
function Hide(id)
{
	var element = null;
	if (document.getElementById)
	{
		element = document.getElementById(id);
	}
	else if (document.all)
	{
		element = document.all[id];
	}
	else if (document.layers)
	{
		element = document.layers[id];
	}
	if (element.style.display == "inline")
	{
		element.style.display = "none";
	}
	else
	{
		element.style.display = "inline";
	}
}

function ShowHideSwap(id1, id2)
{
	switch_visibility(id1);
	switch_visibility(id2);
}

function ShowHide(id1, id2, id3)
{
	var onoff = switch_visibility(id1);
	if (id2 != '')
	{
		switch_visibility(id2);
	}
}

function switch_visibility(id)
{
	var element = null;
	if (document.getElementById)
	{
		element = document.getElementById(id);
	}
	else if (document.all)
	{
		element = document.all[id];
	}
	else if (document.layers)
	{
		element = document.layers[id];
	}

	if (element)
	{
		if (element.style)
		{
			if (element.style.display == "none")
			{
				element.style.display = "";
				return 1;
			}
			else
			{
				element.style.display = "none";
				return 2;
			}
		}
		else
		{
			element.visibility = "show";
			return 1;
		}
	}
}

function is_hidden(id)
{
	var element = null;

	if (document.getElementById)
	{
		element = document.getElementById(id);
	}
	else if (document.all)
	{
		element = document.all[id];
	}
	else if (document.layers)
	{
		element = document.layers[id];
	}

	if (element)
	{
		if (element.style)
		{
			if (element.style.display == "none")
			{
				return(1);
			}
			else
			{
				return(0);
			}
		}
	}
}

function toggle_validation_form_mod(main_form, secondary_form)
{
	// toggle validation based on secondary form visibility //

	var $_hidden = 0;

	$_hidden = is_hidden(secondary_form);

	if ($_hidden == 0)
	{
		document.getElementById(main_form).noValidate=true;
		//alert('Turned off validation');
	}
	else
	{
		document.getElementById(main_form).noValidate=false;
		//alert('Turned on validation');
	}
}

function toggle_validation_form(thisform)
{
	// toggle validation on a given form //

	if (document.getElementById(thisform).noValidate=false)
	{
		document.getElementById(thisform).noValidate=true;
		//alert('Turned off validation');
	}
	else
	{
		document.getElementById(form).noValidate=false;
		//alert('Turned on validation');
	}

}
