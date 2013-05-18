/**
 * @version $Id: scriptaculous_comp.js,v 1.2 2006/11/11 05:01:40 kevinuru Exp $
 */
var sAgent    = navigator.userAgent.toLowerCase();
var is_ie     = (sAgent.indexOf("msie") != -1);
var is_ie7    = (sAgent.indexOf("msie 7") != -1);
var is_gecko  = !is_ie;
var is_safari = (sAgent.indexOf("safari") != -1);
var is_nav    = (sAgent.indexOf("netscape") != -1);

if (is_ie) {
    try {
        document.execCommand("BackgroundImageCache", false, true);
    } catch(e) {};
}


var Zoom = {
  Version: '1.6.5',
  libs: new Array(),
  folded: new Array(),
  connector: null,
  method: 'post',
  state: 'new',
  treenode: null,
  treePinned: true,
  treeDrag: null,
  treePos: null,
  treeCaptionPos: null,
  treeObj: null,
  treeDragNodes: new Array(),
  treeDropNodes: new Array(),
  treeDragObjs: new Array(),
  treeDropObjs: new Array(),
  req_uri: window.location.protocol + "//" + window.location.host + window.location.pathname.replace(/\/(administrator\/)?index(.*)\.php$/i, '') + "/components/com_zoom/www/ajaxcallback.php",
  site_uri: '',
  uid: '0',
  activeCat: '-1',
  activeSubcat: '0',
  lightboxActive: false,
  votingActive: false,
  votingMedium: null,
  require: function(libraryName) {
    // inserting via DOM fails in Safari 2.0, so brute force approach
    document.write('<script type="text/javascript" src="'+libraryName+'"></script>');
  },
  load: function() {
    if((typeof Prototype=='undefined') || 
       (typeof Element == 'undefined') || 
       (typeof Element.Methods=='undefined') ||
       parseFloat(Prototype.Version.split(".")[0] + "." +
                  Prototype.Version.split(".")[1]) < 1.5)
       throw("script.aculo.us requires the Prototype JavaScript framework >= 1.5.0");
    
    $A(document.getElementsByTagName("script")).findAll( function(s) {
      return (s.src && s.src.match(/scriptaculous_comp\.js(\?.*)?$/))
    }).each( function(s) {
      var path = s.src.replace(/scriptaculous_comp\.js(\?.*)?$/,'');
      var includes = s.src.match(/\?.*load=([a-z,]*)/);
      (includes ? includes[1] : 'button,effects,dtree,dragdrop,mm,tjpzoom').split(',').each(
       function(include) { Zoom.require(path+include+'.js') });
    });
  },

    
    provide :
    function() {
        if (arguments.length > 0)
            for (var i = 0; i < arguments.length; i++)
                this.libs.push(arguments[i]);
    },
    
    checkLibraries :
    function() {
        var i, j, libCnt = 0;
        var required = ['button', 'effects', 'dtree', 'dragdrop', 'mm', 'tjpzoom'];
        for (i = 0; i < this.libs.length; i++)
            for (j = 0; j < required.length; j++)
                if (this.libs[i] == required[j]) libCnt++;
        if (libCnt == required.length)
            return true;
        return false;
    },
    
    buildMembersButtons:
    function(node, src, dst) {
        new Zoom.Button('members_add', '', node, {
            width: 22,
            height: 22,
            group: 'members_actions',
            classEnter: 'zmg_nav_btn_right_hover',
            classLeave: 'zmg_nav_btn_right',
            actionData: [src, dst],
            onEnter: function(button) {
                overlib('Add selected group or user to list');
            },
            onLeave : function(button) {
                nd();
            },
            onLeftClick: function(button) {
                Zoom.rebuildMembersList(button.getId(), button.options.actionData[0], button.options.actionData[1]);
            }
        });
        new Zoom.Button('members_remove', '', node, {
            width: 22,
            height: 22,
            group: 'members_actions',
            classEnter: 'zmg_nav_btn_left_hover',
            classLeave: 'zmg_nav_btn_left',
            actionData: [src, dst],
            onEnter: function(button) {
                overlib('Remove selected group or user from list');
            },
            onLeave : function(button) {
                nd();
            },
            onLeftClick: function(button) {
                Zoom.rebuildMembersList(button.getId(), button.options.actionData[0], button.options.actionData[1]);
            }
        });
    },
    
    rebuildMembersList :
    function(button, src, dst) {
        var i;
        var oSrc = $(src);
        var oDst = $(dst);
        if (button.indexOf('add') >= 0) {
            for (i = 0; i < oSrc.childNodes.length; i++) {
                if (oSrc.childNodes[i].selected && oSrc.childNodes[i].value != "0" && !this.hasOption(oDst, oSrc.childNodes[i].value)) {
                    oDst.appendChild(oSrc.childNodes[i].cloneNode(true));
                }
            }
        } else {
            for (i = 0; i < oDst.childNodes.length; i++) {
                if (oDst.childNodes[i].selected) {
                    oDst.removeChild(oDst.childNodes[i]);
                }
            }
        }
    },
    
    buildMembersList :
    function(members, src, dst) {
        var i, j, uid, option;
        var oSrc = $(src);
        var oDst = $(dst);
        // First, clear the destination <SELECT>
        oDst.innerHTML = "";
        if (members != "") {
            // Then we populate it again with the values from the {members} array
            if (typeof members == "string") members = members.split(',');
            for (i = 0; i < members.length; i++) {
                uid = members[i].getAttribute('id');
                if (uid == "1") {
                    option = oSrc.childNodes[3].cloneNode(true);
                } else if (uid == "2") {
                    option = oSrc.childNodes[5].cloneNode(true);
                } else {
                    option = document.createElement('option');
                    option.value = uid;
                    option.innerHTML = uid + "-" + members[i].lastChild.nodeValue + "(" + members[i].getAttribute('username') + ")";
                }
                oDst.appendChild(option);
            }
        }
    },
    
    hasOption :
    function(elmnt, value) {
        var found = false;
        for (var i = 0; i < elmnt.childNodes.length && !found; i++)
            if (elmnt.childNodes[i].nodeName.toLowerCase() == "option")
                if (elmnt.childNodes[i].value == value) found = true;
        return found;
    },
    
    getGalleryTree :
    function(elmnt) {
        this.treenode = elmnt;
        var params = 'uid=' + this.uid + '&id=' + id + '&task=catsmgr_getlist';
        this.connector = new Ajax.Request(this.req_uri, {
            method: this.method, parameters: params,
            onSuccess: this.buildTree});
    },
    
    buildTree : 
    function(callback) {
        Zoom.treeDragNodes = new Array();
        Zoom.treeDropNodes = new Array();
        
        Zoom.treeObj = new dTree('Zoom.treeObj');
        Zoom.treeObj.config.iconPrefix = Zoom.site_uri + '/' + Zoom.treeObj.config.iconPrefix
        Zoom.treeObj.add('root', '-1', LANG_TOPLEVEL);
        Zoom.treeObj.add('new', 'root', LANG_NEW_TITLE, 'javascript:resetFormValues();');
        var nodes = callback.responseXML.getElementsByTagName('zoom');
        for (var i = 0; i < nodes[0].childNodes.length; i++)
            Zoom.buildTreeNodes(nodes[0].childNodes[i], 'root', Zoom.treeObj);
        var tree = $(Zoom.treenode);
        tree.innerHTML = Zoom.treeObj.toString();
        var nodes = document.getElementsByClassName('dTreeNode');
        var mayDrag, mayDrop;
        for (var i = 0; i < nodes.length; i++) {
        	mayDrag = mayDrop = true;
        	mayDrag = (nodes[i].firstChild.id.indexOf('treeObj0') < 0);
        	if (nodes[i].firstChild.nextSibling.id) {
        		if (nodes[i].firstChild.nextSibling.id.indexOf('treeObj1') > 0)
        			mayDrag = mayDrop = false;
        	}
        	if (mayDrag) {
        	    Zoom.treeDragNodes.push(nodes[i]);
        	}
        	if (mayDrop) {
        	    Zoom.treeDropNodes.push(nodes[i]);
        	}
        }
        Zoom.treeSetDragdrop();
    },
    
    treeSetDragdrop:
    function() {
        var i,j, oTree = $('cats_tree');;
        Zoom.treeDragObjs = new Array();
        Zoom.treeDropObjs = new Array();
        for (i = 0; i < Zoom.treeDragNodes.length; i++)
            Zoom.treeDragObjs.push(
                new Draggable(Zoom.treeDragNodes[i], {
                    revert: true,
                    constraint: 'vertical',
                    ghosting: false,
                    scroll: oTree})
            );
        for (j = 0; j < Zoom.treeDropNodes.length; j++)
            Zoom.treeDropObjs.push(
                Droppables.add(Zoom.treeDropNodes[j], {hoverclass: 'dTreeNodeOnDrop',
        			onDrop: function(draggable, droppable, event) {
        				var drag_gallery = Zoom.getGalleryFromElement(draggable);
        				var drop_gallery = Zoom.getGalleryFromElement(droppable);
        				Zoom.resortGallery(drag_gallery, drop_gallery);
        			}})
        	);
    },
    
    treeUnsetDragdrop:
    function() {
        var i,j;
        for (i = 0; i < Zoom.treeDragObjs.length; i++) {
            Zoom.treeDragObjs[i].destroy();
            //Zoom.treeDragObjs = Zoom.treeDragObjs.reject(function(d) { return d==Zoom.treeDragObjs[i] });
        }
        for (j = 0; j < Zoom.treeDropNodes.length; j++)
            Droppables.remove(Zoom.treeDropNodes[j]);
            
    },
    
    resortGallery :
    function(gallery, target) {
    	showMe();
        var params = 'uid=' + this.uid + '&id=' + id + '&catid=' + gallery[0] + '&target=' + target[0] + '&task=catsmgr_resort';
        this.connector = new Ajax.Request(this.req_uri, {
            method: this.method, parameters: params,
            onSuccess: function(callback) {
            	Zoom.getGalleryTree('cats_tree');
            	Zoom.setFormFields(callback);
            }});
    },
    
    getGalleryFromElement :
    function(element) {
    	var a = element.getElementsByTagName('a');
    	if (a.length > 0) {
			var a_pointer = a[a.length - 1].href.substr(31, (a[a.length - 1].href.length - 33)).replace(/\'/gi, '');
			return a_pointer.split(',');
    	}
    	return [0, 0, 0, 0];
    },
    
    buildTreeNodes :
    function(node, parent, tree) {
        var id = node.getAttribute('id');
        var pos = node.getAttribute('pos');
        var published = node.getAttribute('published');
        var shared = node.getAttribute('shared');
        var uid = node.getAttribute('uid');
        tree.add(id, parent, node.getAttribute('name'), 'javascript:Zoom.ongalleryclick(\'' + id + '\',\'' + 
            pos + '\',\'' + published + '\',\'' + 
            shared + '\',\'' + uid + '\');',
            '', '', tree.config.iconPrefix + tree.icon.folder, tree.config.iconPrefix + tree.icon.folderOpen, '',
            'Zoom.ongalleryhover(\'' + id + '\',\'' + pos + '\',\'' + published + '\',\'' + shared + '\',\'' + uid + '\');', 'return nd();');
        for (var i = 0; i < node.childNodes.length; i++)
            this.buildTreeNodes(node.childNodes[i], id, tree);
    },
    
    ongalleryclick :
    function(catid, pos, published, shared, uid) {
        showMe();
        var params = 'uid=' + this.uid + '&id=' + id + '&catid=' + catid + '&task=catsmgr_editform';
        this.connector = new Ajax.Request(this.req_uri, {
            method: this.method, parameters: params,
            onSuccess: Zoom.setFormFields });
    },
    
    getNewDir :
    function() {
    	var params = 'uid=' + this.uid + '&id=' + id + '&task=catsmgr_newdir';
        this.connector = new Ajax.Request(this.req_uri, {
            method: this.method, parameters: params,
            onSuccess: function(callback) {
            	var nodes = callback.responseXML.getElementsByTagName('newdir');
            	if (nodes.length >= 1) {
            		document.catsmgr.elements['catdir'].value = nodes[0].firstChild.nodeValue;
            	}
            }});
    },
    
    setFormFields :
    function(callback) {
    	//alert(callback.responseText);
        var msg;
        hideMe();
        Zoom.getToolbar('catsmgr_editform');
        Zoom.getParentOptions();
        var result = callback.responseXML.getElementsByTagName('result');
        if (result[0].firstChild.nodeValue == "KO") {
            msg = callback.responseXML.getElementsByTagName('reason');
            if (msg[0] && msg[0].firstChild.nodeValue != "none") alert(msg[0].firstChild.nodeValue);
        } else if (result[0].firstChild.nodeValue == "OK") {
            msg = callback.responseXML.getElementsByTagName('msg');
            if (msg[0] && msg[0].firstChild.nodeValue != "none") {
                alert(msg[0].firstChild.nodeValue);
                Zoom.getGalleryTree('cats_tree');
            }
            
            var galleries = callback.responseXML.getElementsByTagName('gallery');
            var gallery = galleries[0];
            if (gallery) {
                Zoom.state = 'edit';
                var members = gallery.getElementsByTagName('member');
                Zoom.activeCat = gallery.getAttribute('id');
                Zoom.activeSubcat = gallery.getAttribute('subcat_id');
                setFormValues(Zoom.activeCat, decodeURIComponent(gallery.getAttribute('name')), decodeURIComponent(gallery.getAttribute('dir')), 
                    decodeURIComponent(gallery.getAttribute('password')), gallery.getAttribute('keywords'), unescape(gallery.lastChild.nodeValue),
                    Zoom.activeSubcat, gallery.getAttribute('pos'),
                    gallery.getAttribute('hide_msg'), gallery.getAttribute('published'), gallery.getAttribute('shared'));
                Zoom.buildMembersList(members, 'members_opt', 'members_sel');
            } else {
                Zoom.state = 'new';
                resetFormValues();
            }
        }
    },
    
    ongalleryhover :
    function(id, pos, published, shared, uid) {
        var html = '<img src="' + Zoom.site_uri;
        if (published == "1") {
            html += '/components/com_zoom/www/images/publish_g.png" alt="" border="0" />&nbsp;' +
                LANG_PUBLISHED + ': <b>' + LANG_YES + '</b>';
        } else {
            html += '/components/com_zoom/www/images/publish_x.png" alt="" border="0" />&nbsp;' +
                LANG_PUBLISHED + ': <b>' + LANG_NO + '</b>';
        }
        html += '<br /><img src="' + Zoom.site_uri;
        if (shared == "1") {
            html += '/components/com_zoom/www/images/share_u.png" alt="" border="0" />&nbsp;' +
                LANG_SHARED + ': <b>' + LANG_YES + '</b>';
        } else {
            html += '/components/com_zoom/www/images/share_l.png" alt="" border="0" />&nbsp;' +
                LANG_SHARED + ': <b>' + LANG_NO + '</b>';
        }
        html += '<br /><img src="' + Zoom.site_uri +'/components/com_zoom/www/images/home.gif" alt="" border="0" />ID: <strong>' + id + '</strong>';
        overlib(html);
    },
    
    getToolbar :
    function(action) {
        var buttons;
        if (typeof action == "undefined") action = "catsmgr";
        var params = 'uid=' + this.uid + '&id=' + id + '&action=' + action + '&task=get_toolbar';
        this.connector = new Ajax.Request(this.req_uri, {
            method: this.method, parameters: params,
            onSuccess: this.buildToolbar});
    },
    
    buildToolbar :
    function(callback) {
        var buttons = callback.responseXML.getElementsByTagName('button');
        var toolbar = $('toolbar'), name;
        toolbar.innerHTML = "";
        for (var i = 0; i < buttons.length; i++) {
            name = buttons[i].getAttribute('type');
            new Zoom.Button(name, '', toolbar, {
                width: 32,
                height: 32,
                group: buttons[i].getAttribute('caption'),
                classEnter: 'zmg_tb_btn_' + name + '_hover',
                classLeave: 'zmg_tb_btn_' + name,
                onEnter: function(button) {
                    overlib(button.options.group);
                },
                onLeave : function(button) {
                    nd();
                },
                onLeftClick: function(button) {
                    Zoom.dispatch(button.getId());
                }
            });
        }
    },
    
    getParentOptions :
    function() {
        var params = 'uid=' + this.uid + '&id=' + id + '&task=get_galleries';
        this.connector = new Ajax.Request(this.req_uri, {
            method: this.method, parameters: params,
            onSuccess: this.setParentOptions});
    },
    
    setParentOptions :
    function(callback) {
        var oParent = document.catsmgr.elements['parent'];
        var sel = "0";
        
        var options = callback.responseXML.getElementsByTagName('gallery');
        var option, id;
        
        oParent.innerHTML = "";
        for (var j = 0; j < options.length; j++) {
            id = options[j].getAttribute('id');
            if (id != Zoom.activeCat) {
                var option = document.createElement('option');
                option.value = id;
                option.innerHTML = options[j].firstChild.nodeValue;
                if (option.value == Zoom.activeSubcat)
                    option.selected = true;
                oParent.appendChild(option);
            }
        }
    },
    
    dispatch :
    function(action) {
        var i, descr = getEditorContent();
        if (descr == null)
            descr = $F('catdescr');
        var form = document.catsmgr;
        var oParent = form.elements['parent'];
        var sParent = "0";
        if (action == "delete" && !confirm(LANG_CONFIRM_DEL)) return;
        showMe();
        for (i = 0; i < oParent.childNodes.length; i++)
            if (oParent.childNodes[i].selected) sParent = oParent.childNodes[i].value;
        var params = 'uid=' + this.uid + '&id=' + id + '&catid=' + $F('catid') + '&task=catsmgr_' + action + '&parent=' + sParent +
            '&name=' + encodeURIComponent($F('catname')) + '&dir=' + encodeURIComponent($F('catdir')) +
            '&password=' + encodeURIComponent($F('catpassword')) + '&keywords=' + encodeURIComponent($F('catkeywords')) +
            '&descr=' + encodeURIComponent(descr) + '&hide_msg=' + ((form.elements['hidemsg'].checked) ? "1" : "0") +
            '&published=' + ((form.elements['published'].checked) ? "1" : "0") + '&shared=' + ((form.elements['shared'].checked) ? "1" : "0");
        for (i = 0; i < form.elements['members_sel'].options.length; i++)
            params += '&members_sel[]=' + form.elements['members_sel'].options[i].value;
        this.connector = new Ajax.Request(this.req_uri, {
            method: this.method, parameters: params,
            onSuccess: Zoom.setFormFields });
    },
    
    doPinTree: function() {
        if (this.treePinned)
            this.unpinTree();
        else
            this.pinTree();
    },
    
    unpinTree: function() {
        //if (is_ie) this.treeUnsetDragdrop();
        var oTree = $('cats_tree_container');
        var oTreeCaption = $('cats_tree_caption');
        oTree.style.zIndex = 200;
        oTreeCaption.style.zIndex = 200;
        Position.prepare();
        Position.absolutize(oTree);
        Position.absolutize(oTreeCaption);
        var aPosT = Position.page(oTree);
        var aPosC = Position.page(oTreeCaption);
        this.treePos = [aPosT[0] + Position.deltaX, aPosT[1] + Position.deltaY];
        this.treeCaptionPos = [aPosC[0] + Position.deltaX, aPosC[1] + Position.deltaY];
        Element.addClassName($('cats_tree'), 'cats_tree_unpinned');
        Element.addClassName(oTreeCaption, 'cats_tree_caption_unpinned');
        this.treeDrag = new Draggable(oTreeCaption);
        oTreeCaption.style.cursor = "move";
        document.body.appendChild(oTreeCaption);
        document.body.appendChild(oTree);
        Element.hide($('cats_tree_table'));
        var oImg = $('cats_tree_pinimg');
        oImg.src = oImg.src.replace(/unpin.gif/, 'pin.gif');
        this.treePinned = false;
        this.dragTree(this.treeDrag);
    },
    
    pinTree: function() {
        //if (is_ie) this.treeSetDragdrop();
        var oTree = $('cats_tree_container');
        var oTable = $('cats_tree_table');
        var oTreeCaption = $('cats_tree_caption');
        oTree.style.zIndex = 0;
        oTreeCaption.style.zIndex = 0;
        Element.show(oTable);
        Position.prepare();
        oTree.style.left = this.treePos[0] + "px";
        oTree.style.top = this.treePos[1] + "px";
        oTreeCaption.style.left = this.treeCaptionPos[0] + "px";
        oTreeCaption.style.top = this.treeCaptionPos[1] + "px";
        Position.relativize(oTree);
        Position.relativize(oTreeCaption);
        this.treeDrag.destroy();
        this.treeDrag = null;
        oTreeCaption.style.cursor = "";
        Element.removeClassName($('cats_tree'), 'cats_tree_unpinned');
        Element.removeClassName(oTreeCaption, 'cats_tree_caption_unpinned');
        oTable.appendChild(oTreeCaption);
        oTable.appendChild(oTree);
        var oImg = $('cats_tree_pinimg');
        oImg.src = oImg.src.replace(/pin.gif/, 'unpin.gif');
        this.treePinned = true;
    },
    
    dragTree:
    function(draggable) {
        if (draggable == this.treeDrag) {
            var d = draggable.currentDelta();
            //$('catsmgr_tabs_page1').innerHTML += "DEBUG: " + draggable + ", " + pos[0] + ", " + pos[1] + "<br />";
            var oTree = $('cats_tree_container');
            oTree.style.left = d[0] + "px";
            oTree.style.top = (d[1] + 15) + "px";
        }
    },
    
    unit_save_vote :
    function(imgid, vote) {
        if (!this.votingActive) {
            var params = 'uid=' + this.uid + '&id=' + id + '&task=view_vote&imgid=' + imgid + '&vote=' + vote;
            this.votingMedium = imgid;
            this.votingActive = true;
            this.connector = new Ajax.Request(this.req_uri, {
                method: 'post', parameters: params,
                onSuccess: this.unit_update_vote });
        }
    },
    
    unit_update_vote :
    function(callback) {
        Zoom.votingActive = false;
        var msgContainer = $('unit_long' + Zoom.votingMedium);
        var result = callback.responseXML.getElementsByTagName('result');
        if (result[0].firstChild.nodeValue == 'KO') {
            msg = callback.responseXML.getElementsByTagName('reason');
            if (msg[0] && msg[0].firstChild.nodeValue != 'none') msgContainer.innerHTML = msg[0].firstChild.nodeValue;
        } else if (result[0].firstChild.nodeValue == 'OK') {
            msg = callback.responseXML.getElementsByTagName('msg');
            if (msg[0] && msg[0].firstChild.nodeValue != 'none') msgContainer.innerHTML = msg[0].firstChild.nodeValue;
        }
    },
    
    lightboxAdd :
    function(imgid, type, image) {
        if (!this.lightboxActive) {
            var params = 'uid=' + this.uid + '&id=' + id + '&task=view_lightbox&imgid=' + imgid + '&type=' + type;
            this.lightboxObj = image;
            image.src = Zoom.site_uri + '/components/com_zoom/www/images/indicator.gif';
            this.connector = new Ajax.Request(this.req_uri, {
                method: 'post', parameters: params,
                onSuccess: this.lightboxResult });
        }
        
    },
    
    lightboxResult :
    function(callback) {
        Zoom.lightboxActive = false;
        var result = callback.responseXML.getElementsByTagName('result');
        if (result[0].firstChild.nodeValue == 'KO') {
            msg = callback.responseXML.getElementsByTagName('reason');
            Zoom.lightboxObj.src = Zoom.site_uri + '/components/com_zoom/www/images/delete.png';
            if (msg[0] && msg[0].firstChild.nodeValue != 'none') Zoom.lightboxObj.parentNode.onmouseover = function(){return overlib(msg[0].firstChild.nodeValue, CAPTION, lb_title);};
        } else if (result[0].firstChild.nodeValue == 'OK') {
            msg = callback.responseXML.getElementsByTagName('msg');
            Zoom.lightboxObj.src = Zoom.site_uri + '/components/com_zoom/www/images/priv_yes.png';
            if (msg[0] && msg[0].firstChild.nodeValue != 'none') Zoom.lightboxObj.parentNode.onmouseover = function(){return overlib(msg[0].firstChild.nodeValue, CAPTION, lb_title);};
        }
    },
    
    slide :
    function(what, siteUrl) {
        var theImage = "";
        if (Zoom.folded[what] == 1) {
          new Effect.SlideDown($(what + 'Body'), {duration: 0.5});
          Zoom.folded[what] = 0;
          theImage = siteUrl + "/components/com_zoom/www/images/blocks/arrow_up_white.png";
        } else {
          new Effect.SlideUp($(what + 'Body'), {duration: 0.5});
          Zoom.folded[what] = 1;
          theImage = siteUrl + "/components/com_zoom/www/images/blocks/arrow_down_white.png";
        }
        MM_swapImage(what + 'Image', '', theImage, 1);
    },
    
    toggleDisplay :
    function(what, siteUrl) {
        var theImage;
        if (Zoom.folded[what] == 1) {
          new Element.show($(what + 'Body'));
          Zoom.folded[what] = 0;
          theImage = "/components/com_zoom/www/images/blocks/arrow_up_white.png";
          MM_swapImage(blockImage, '', theImage, 1);
        } else {
          new Element.hide($(what + 'Body'));
          Zoom.folded[what] = 1;
          theImage = siteUrl + "/components/com_zoom/www/images/blocks/arrow_down_white.png";
        }
        MM_swapImage(what + 'Image', '', theImage, 1);
    },
    
    changeArrow :
    function(what, color, siteUrl) {
        var theImage = "";
        var direction = "";
        if (Zoom.folded[what] == 1) {
            direction = "down";
        } else {
            direction = "up";
        }
        theImage = siteUrl + "/components/com_zoom/www/images/blocks/arrow_" + direction + "_" + color + ".png";
        MM_swapImage(what + 'Image', '', theImage, 1);
    },

    emoticon :
    function(text) {
        var txtarea = document.post.comment;
        text = ' ' + text + ' ';
        if (txtarea.createTextRange && txtarea.caretPos) {
        	var caretPos = txtarea.caretPos;
        	caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
        	txtarea.focus();
        } else {
        	txtarea.value  += text;
        	txtarea.focus();
        }
    },
    
    storeCaret :
    function(textEl) {
        if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
    },
    
    
    getWindowSize :
    function (win) {
    	if (typeof win == "undefined")
    		win = window;
     	if (win.innerHeight != null)
     		return {width: win.innerWidth, height:  win.innerHeight};
    	if (win.document.documentElement && win.document.documentElement.clientHeight)
    		return this.getElementSize(win.document.documentElement);
    	if (win.clientHeight != null)
    		return {width: win.clientWidth, height: win.clientHeight};
    	return this.getElementSize(win.document.body);
    },
    
    getElementSize :
    function (el) {
     	if (el.offsetHeight)
     		return {width: el.offsetWidth, height: el.offsetHeight};
    	if (el.style && el.style.width && el.style.height)
     		return {width: parseInt(el.style.width), height: parseInt(el.style.height)};
    	if (el.clientHeight)
     		return {width: el.clientWidth, height: el.clientHeight};
    	return {width: -1, height: -1};
    }
}

Zoom.load();