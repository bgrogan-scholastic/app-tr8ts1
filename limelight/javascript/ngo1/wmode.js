// flash wmode fix
function TopParent( w)
{
	var topParent = null;
	while ((w)&&(w != topParent))
	{
		topParent = w;
		w = w.parent;
	}
	return topParent;
}
function IsObject( w)
{
	var bIs = true;
	if (!w)
	{
		bIs = false;
	}
	//alert( "IsObject = "+bIs);
	return bIs;
}
function GetIdItem( strId, w)
{
	if ( IsObject( w))
	{
		return w.document.getElementById( strId);
	}
	return document.getElementById( strId);
}

function GetItemValue( w)
{
	//alert( "GetItemValue( "+w+")");
	var value = false;
	if ( IsObject( w))
	{
		value = w.value;
	}
	return value;
}

function GetItemText( w)
{
	var value = false;
	if ( IsObject( w))
	{
		value = w.lastChild.nodeValue;
	}
	return value;
}

function SetItemValue( w, value) { if ( IsObject( w)) { w.value = value; } }
function SetItemText( w, value) { if ( IsObject( w)) { w.lastChild.nodeValue = value; } }
function IsChecked( w)
{
	if ( IsObject( w))
	{
		return w.checked;
	}
}
function GetCheckedItem( arItems)
{
	var item = null;
	if ( IsObject( arItems))
	{
		for (var i=0; (( item == null) && ( i<arItems.length)); i++) 
		{
			if ( IsChecked( arItems[i]))
				item = arItems[i];
		}
	}
	return item;
}

function SetItemChecked( w, bChecked)
{
	if ( IsObject( w))
	{
		var bCheckedValue;
		bCheckedValue = false;
		if ( bChecked)
			bCheckedValue = true;
		w.checked = bCheckedValue;
		//alert( "SetItemChecked = "+w.checked);
	}
}
function SetItemAction( w, script) { w.action = script; }
function SetItemActionPosition( w, strPosition)
{
	if ( IsObject( w))
	{
		var strAction = w.action;
		var nIndexOfPosition = strAction.indexOf( "#");
		if ( nIndexOfPosition >= 0)
		{
			strAction = strAction.substr( 0, nIndexOfPosition);
		}
		if ( strPosition)
			strAction += "#" + strPosition;
		w.action = strAction;
	}
}

function GetNamedItems( strName, w)
{
	//alert( "GetNamedItems( "+strName+", "+w+")");
	if ( IsObject( w))
	{
		return w.document.getElementsByName( strName);
	}
	return document.getElementsByName( strName);
}

function GetFirstItemByName( strName, w)
{
	//alert( "GetFirstItemByName( "+strName+", "+w+")");
	var arItems = GetNamedItems( strName, w);
	if ( arItems.length > 0)
	{
		return arItems[0];
	}
	return null;
}

function SetItemListValue( arItems, value)
{
	if ( IsObject( arItems))
	{
		for (var i=0; i<arItems.length; i++) 
		{
			SetItemValue( arItems[i], value);
		}
	}
}
function SetItemListText( arItems, value)
{
	if ( IsObject( arItems))
	{
		for (var i=0; i<arItems.length; i++) 
		{
			SetItemText( arItems[i], value);
		}
	}
}
function SetItemListChecked( arItems, bChecked)
{
	if ( IsObject( arItems))
	{
		for (var i=0; i<arItems.length; i++) 
		{
			SetItemChecked( arItems[i], bChecked);
		}
	}
}

function SetValueByName( strInputName, strValue) { SetItemListValue( GetNamedItems( strInputName), ''); return true; }
function SetClassName( item, strClassName)
{
	if ( item)
		item.className = strClassName;
	return true;
}

function SetClassNameById( nId, strClassName, w)
{
  var item;
  SetClassName( GetIdItem( nId, w), strClassName);
  return true;
}

function SetClassNameByName( strName, strClassName, w)
{
  var arItems;
	arItems = GetNamedItems( strName, w);
	for (var i=0; i<arItems.length; i++) 
	{
		SetClassName( arItems[i], strClassName);
	}
  return true;
}

function SetDisplayStyle( item, strDisplay)
{
	if ( item)
		item.style.display = strDisplay;
	return true;
}

function SetDisplayStyleById( nId, strDisplay, w) { var item; SetDisplayStyle( GetIdItem( nId, w), strDisplay); return true; }
function DoSubmit( strFormId) { var form = GetIdItem( strFormId); form.submit(); }
function FirstId( strIdList, strDelimiter)
{
	var strResult = strIdList;
	var nIndex = strIdList.indexOf( strDelimiter);
	if ( nIndex >= 0)
		strResult = strIdList.substr( 0, nIndex);
	return strResult;
}

function CheckedInputValue( strInputName)
{
	var strValue = false;
	var item = GetCheckedItem( GetNamedItems( strInputName, null));
	if ( item)
	{
		strValue = GetItemValue( item);
	}
	return strValue;
}

function SetOpenerLocation( strLocation)
{
	var bChanged = false;
	if ( strLocation != null)
	if ( strLocation != '')
	if ( top.opener)
	{
		try
		{
			top.opener.location = strLocation;
			bChanged = true;
		}
		catch (e)
		{
			bChanged = false;
		}
	}
	return bChanged;
}

function AddEventHandler( strEventName, hOnEvent, obj, bCapture)
{
	if (obj == null)
		obj = window;
	if ( bCapture == null)
		bCapture = false;
	if ( obj.addEventListener)
		obj.addEventListener( strEventName, hOnEvent, bCapture);
	else
	if ( obj.attachEvent)
	{
		obj.attachEvent( 'on'+strEventName, hOnEvent);
	}
}

function CancelEventBuble( e)
{
	if ( e == null)
	{
		// IE if event set by "document.onmousedown = handler" or something like this
		e = event;
	}
	if ( e.stopPropagation)
	{
		e.stopPropagation();
		e.preventDefault();
	}
	else
	{
		e.returnValue = false;
		e.cancelBubble = true;
	}
}


function RemoveAllChild( node)
{
	if ( node)
	while ( node.firstChild)
	{
		RemoveAllChild( node.firstChild)
		node.removeChild( node.firstChild);
	};
}
// Browsers.js
function IsSafari()
{
	return (navigator.appVersion.search('Safari')>0);
}

function IsNN()
{
	return (navigator.appName=='Netscape');
}

function IsOpera()
{
	if ( window.opera )
		return true;
	return false;
}

function IsIE()
{
	if ( document.all)
		return !IsOpera();
	return false;
	//return (navigator.appName=='Microsoft Internet Explorer');
}

function IsWindows()
{
	if ( navigator.platform == 'Win32')
		return true;
	return false;
}

function IsOldOpera()
{
	var bIs = false;
	if ( IsOpera())
	{
		bIs = true;
		if ( parseInt( navigator.appVersion) > 8)
			bIs = false;
	}
	return bIs;
}

function IsOldIE()
{
	var bIs = false;
	if ( IsIE())
	{
		bIs = true;
		var strMsieMarker = 'MSIE';
		var nVersionPosition = navigator.appVersion.indexOf( strMsieMarker);
		if ( nVersionPosition >= 0)
		{
			nVersionPosition += strMsieMarker.length;
			if ( parseInt( navigator.appVersion.substr( nVersionPosition)) > 6)
				bIs = false;
		}
	}
	return bIs;
}

function IsXhtmlCompatMode()
{
	if ( document.compatMode == "CSS1Compat")
		return true;
	return false;
}

function IsContainParam( strInnerHtml)
{
	var bContain;
	if ( strInnerHtml)
	if (( strInnerHtml.indexOf( '<param') >= 0)
		||( strInnerHtml.indexOf( '<PARAM') >= 0)
			)
	{
		bContain = true;
	}
	return bContain;
}
function FixObjectActivateAlert( obj)
{
	if ( !IsContainParam( obj.innerHTML))
	{
		var strParamHtml = '';
		var arParam = obj.childNodes;
		var i = 0;
		for ( i = 0; i < arParam.length; i++)
		{
			if ( arParam[ i].tagName.toLowerCase() == 'param')
				strParamHtml += arParam[ i].outerHTML;
		}
		var strResult = obj.outerHTML.replace( '>', '>'+strParamHtml);
		obj.outerHTML = strResult;
	}
	else
	{
		obj.outerHTML = obj.outerHTML;
	}
}

function FixAllObjectActivateAlert( strTagName)
{
	var arObj = document.getElementsByTagName( strTagName);
	var i = 0;
	for ( i = 0; i < arObj.length; i++)
	{
		FixObjectActivateAlert( arObj[ i]);
	}
}

function FixFlashActivateAlert()
{
	if ((( IsIE()) && ( !IsOldIE()))
		||(( IsOpera()) && ( !IsOldOpera()))
		 )
	{
		FixAllObjectActivateAlert( 'object');
		FixAllObjectActivateAlert( 'embed');
	}
}

function HasWmodeParam( obj)
{
	var bIsWmode = false;
	if ( obj)
	{
		var arAllChild = obj.childNodes;
		var i = 0;

		for ( i = 0; (( !bIsWmode) && ( i < arAllChild.length)); i++)
		{
			if ( arAllChild[ i].tagName)
			if ( arAllChild[ i].tagName.toLowerCase() == 'param')
			{
				var strParamName = arAllChild[ i].getAttribute( 'name');

				if ( strParamName)
				if ( strParamName.toLowerCase() == 'wmode')
				{
					if ( arAllChild[ i].getAttribute( 'value').toLowerCase() != 'window')
						bIsWmode = true;
				}
			}
		}
	}
	return bIsWmode;
}

function AddWmodeParam( obj, strValue)
{
	if ( obj)
	{
		var arAllChild = obj.childNodes;
		var i = 0;
		var bIsWmode = false;
		var strMovie = null;

		for ( i = 0; ((( !bIsWmode) || ( strMovie == null)) && ( i < arAllChild.length)); i++)
		{
			if ( arAllChild[i].tagName)
			if ( arAllChild[i].tagName.toLowerCase() == 'param')
			{
				var strParamName = arAllChild[i].getAttribute( 'name');

				if ( strParamName)
				if ( strParamName.toLowerCase() == 'wmode')
				{
					if ( arAllChild[i].getAttribute( 'value').toLowerCase() != 'window')
						bIsWmode = true;
				}
				else
				if ( strParamName.toLowerCase() == 'movie')
					strMovie = arAllChild[i].getAttribute( 'value');
			}
		}
		
		if ( !bIsWmode)
		{
			var paramNew = document.createElement( 'param');

			paramNew.setAttribute('name', 'wmode');
			paramNew.setAttribute('value', strValue);

			var objClone = obj.cloneNode(true);
			RemoveWmodeParam( objClone);
			objClone.appendChild( paramNew);
			
			if ( IsOpera())
			//if ( !IsIE())
			{
				objClone.setAttribute('type', 'application/x-shockwave-flash');
				objClone.setAttribute('data', strMovie);
				objClone.removeAttribute('codebase');
				objClone.removeAttribute('classid');
				RemoveEmbed( objClone);
			}
			
			AddWmodeToChildEmbed( objClone, strValue);

			var parent = obj.parentNode;
			if( objClone && parent)
			{
				parent.replaceChild( objClone, obj);
			}

			if ((( IsIE()) && ( !IsOldIE()))
				||( IsOpera())
				 )
			{
				FixObjectActivateAlert( objClone);
			}
		}
	}
}
function RemoveWmodeParam(obj)
{
	if ( obj)
	{
		var arAllChild = obj.childNodes;
		var i = 0;
		for ( i = arAllChild.length -1; i >= 0; i--)
		{
			if ( arAllChild[i].tagName)
			if ( arAllChild[i].tagName.toLowerCase() == 'param')
			{
				var strParamName = arAllChild[i].getAttribute( 'name');

				if ( strParamName)
				if ( strParamName.toLowerCase() == 'wmode')
				{
					obj.removeChild( arAllChild[i]);
				}
			}
		}
	}
}
function AddWmodeToChildEmbed( obj, strValue)
{
	var arAllChild = obj.childNodes;
	var i = 0;
	for ( i = 0; i < arAllChild.length; i++)
	{
		if ( arAllChild[i].tagName)
		if ( arAllChild[i].tagName.toLowerCase() == 'embed')
		{
			AddWmodeAttribute( arAllChild[i], strValue);//, true);
		}
	}
}

function RemoveEmbed(obj)
{
	var arAllChild = obj.childNodes;
	var i = 0;
	for ( i = ( arAllChild.length - 1); i >= 0; i--)
	{
		if ( arAllChild[i].tagName)
		if ( arAllChild[i].tagName.toLowerCase() == 'embed')
		{
			obj.removeChild( arAllChild[i]);
		}
	}
}

function HasWmodeAttribute( obj)
{
	var bIsWmode = false;
	if ( obj)
	{
		var strOldValue = obj.getAttribute( 'wmode');
		if ( strOldValue != null)
		if ( strOldValue != '')
		if ( strOldValue.toLowerCase() != 'window') { bIsWmode = true; }
	}
	return bIsWmode;
}

function AddWmodeAttribute( obj, strValue)//, bRemove)
{
	if ( obj)
	{
		var bIsWmode = false;
		var strOldValue = obj.getAttribute( 'wmode');
		if ( strOldValue != null)
		if ( strOldValue != '') { bIsWmode = true; }
		
		if ( !bIsWmode)
		{
			var objClone = obj.cloneNode(true);
			objClone.setAttribute( 'wmode', strValue);
			var parent = obj.parentNode;
			if( objClone && parent) { parent.replaceChild( objClone, obj); }
		}
	}
}
function IsFlashType( strType)
{
	var bIsFlash = false;
	if ( strType != null)
	if ( strType.indexOf( 'shockwave') > 0) bIsFlash = true;
	return bIsFlash;
}

function NeedObjectWmodeFix()
{
	var bNext = true;
	var arObj = document.getElementsByTagName( 'object');

	var i = 0;
	for ( i = 0; (( bNext)&&( i < arObj.length)); i++)
	{
		var obj = arObj[ i];
		if (( IsFlashType( obj.getAttribute('type')))
			||( IsFlashType( obj.getAttribute('codebase')))
				)
		{
			try
			{
				bNext = HasWmodeParam(obj);
			}
			catch (e) { }
		}
	}
	return !bNext;
}

function AllObjectCount()
{
	var arObj = document.getElementsByTagName( 'object');
	if ( arObj)
		return arObj.length;
	return 0;
}

function FixAllObjectWmode( strValue)
{
	var arObj = document.getElementsByTagName( 'object');

	var i = 0;
	for ( i = 0; i < arObj.length; i++)
	{
		var obj = arObj[ i];
		if (( IsFlashType( obj.getAttribute( 'type')))
			||( IsFlashType( obj.getAttribute( 'codebase')))
				)
		{
			try
			{
				AddWmodeParam( obj, strValue);
			}
			catch ( e)
			{
			}
		}
	}
}

function NeedEmbedWmodeFix()
{
	var bNext = true;
	var arObj = document.getElementsByTagName( 'embed');
	var i = 0;
	for ( i = 0; (( bNext)&&( i < arObj.length)); i++)
	{
		var obj = arObj[ i];
		if ( IsFlashType( obj.getAttribute( 'type')))
		{
			bNext = HasWmodeAttribute( obj);
		}
	}
	return !bNext;
}
function FixAllEmbedWmode( strValue)
{
	var arObj = document.getElementsByTagName( 'embed');
	var i = 0;
	for ( i = 0; i < arObj.length; i++)
	{
		var obj = arObj[ i];
		if ( IsFlashType( obj.getAttribute( 'type')))
		{
			AddWmodeAttribute( obj, strValue);
		}
	}
}

function NeedFixWmode()
{
	if ( !NeedObjectWmodeFix())
	if ( !NeedEmbedWmodeFix())
		return false;
	return true;
}

function FixAllWmode( strValue)
{
	FixAllObjectWmode( strValue);
	FixAllEmbedWmode( strValue);
}


function CFixWmode()
{
	this.m_nTimer = null;
	this.m_bOnLoadTimer = false;
	this.m_bShortTimer = false;
	this.m_strWmodeToSet = 'opaque';
	this.m_nObjectCountPrev = 0;
}

CFixWmode.prototype.NeedTimer = function()
{
	if (this.m_bOnLoadTimer || this.m_bShortTimer)
		return true;
	return false;
}

CFixWmode.prototype.IsShortTimer = function()
{
	return this.m_bShortTimer;
}

CFixWmode.prototype.TimerInterval = function()
{
	var nTimeInterval = 300;
	if ( this.IsShortTimer())
		nTimeInterval = 20;
	return nTimeInterval;
}

CFixWmode.prototype.WmodeToSet= function()
{
	return this.m_strWmodeToSet;
}

CFixWmode.prototype.FixWmode = function()
{
	var nObjectCount = AllObjectCount();
	if ( nObjectCount > 0)
	if ( this.m_nObjectCountPrev != nObjectCount)
	{
		this.m_nObjectCountPrev = nObjectCount;
		FixAllWmode( this.WmodeToSet());
		this.m_bShortTimer = false;
	}
}

CFixWmode.prototype.FixWmodeTimerProc = function()
{
	this.FixWmode();
	this.m_nTimer = null;
	if ( this.NeedTimer())
	{
		this.m_nTimer = setTimeout( FixWmodeTimerProc, this.TimerInterval());
	}
}

CFixWmode.prototype.StartTimer = function( )
{
	this.m_bOnLoadTimer = true;
	this.m_bShortTimer = true;
	this.m_nTimer = setTimeout( FixWmodeTimerProc, this.TimerInterval());
}

CFixWmode.prototype.StopTimer = function( )
{
	if ( this.m_nTimer != null)
	{
		clearTimeout( this.m_nTimer);
		this.m_nTimer = null;
	}
}

var s_fixWmode = null;

function FixWmodeTimerProc()
{
	if ( s_fixWmode)
	{
		s_fixWmode.FixWmodeTimerProc();
	}
}

function FixWmodeWhenLoaded()
{
	if ( s_fixWmode)
	{
		s_fixWmode.FixWmode();
	}
}

function StopFixWmodeTimer()
{
	if ( s_fixWmode)
	{
		s_fixWmode.StopTimer();
	}
}

function FixWmodeInTimer()
{
	if ( s_fixWmode == null)
	{
		s_fixWmode = new CFixWmode();
		s_fixWmode.StartTimer();
		AddEventHandler( 'load', StopFixWmodeTimer);
	}
}


var fRun = true;
function fixDaFlash() {
	if (NeedFixWmode() && fRun)
	{
		s_fixWmode = new CFixWmode();
		s_fixWmode.FixWmode();
		fRun = false;
	}
}
AddEventHandler( 'DOMContentLoaded', fixDaFlash);
AddEventHandler('load',fixDaFlash);