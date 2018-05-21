/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

SUGAR.measurements = {
  "breakpoints": {
    "x-small": 750,
    "small": 768,
    "medium": 992,
    "large": 1130,
    "x-large": 1250
  }
};

SUGAR.loaded_once = false;

$(document).ready(function () {
  loadSidebar();
  $("ul.clickMenu").each(function (index, node) {
    $(node).sugarActionMenu();
  });
  // Back to top animation
  $('#backtotop').click(function (event) {
    event.preventDefault();
    $('html, body').animate({scrollTop: 0}, 500); // Scroll speed to the top
  });
});
YAHOO.util.Event.onAvailable('sitemapLinkSpan', function () {
  document.getElementById('sitemapLinkSpan').onclick = function () {
    ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING_PAGE'));
    var smMarkup = '';
    var callback = {
      success: function (r) {
        ajaxStatus.hideStatus();
        document.getElementById('sm_holder').innerHTML = r.responseText;
        with (document.getElementById('sitemap').style) {
          display = "block";
          position = "absolute";
          right = 0;
          top = 80;
        }
        document.getElementById('sitemapClose').onclick = function () {
          document.getElementById('sitemap').style.display = "none";
        }
      }
    }
    postData = 'module=Home&action=sitemap&GetSiteMap=now&sugar_body_only=true';
    YAHOO.util.Connect.asyncRequest('POST', 'index.php', callback, postData);
  }
});
function IKEADEBUG() {
  var moduleLinks = document.getElementById('moduleList').getElementsByTagName("a");
  moduleLinkMouseOver = function () {
    var matches = /grouptab_([0-9]+)/i.exec(this.id);
    var tabNum = matches[1];
    var moduleGroups = document.getElementById('subModuleList').getElementsByTagName("span");
    for (var i = 0; i < moduleGroups.length; i++) {
      if (i == tabNum) {
        moduleGroups[i].className = 'selected';
      }
      else {
        moduleGroups[i].className = '';
      }
    }
    var groupList = document.getElementById('moduleList').getElementsByTagName("li");
    var currentGroupItem = tabNum;
    for (var i = 0; i < groupList.length; i++) {
      var aElem = groupList[i].getElementsByTagName("a")[0];
      if (aElem == null) {
        continue;
      }
      var classStarter = 'notC';
      if (aElem.id == "grouptab_" + tabNum) {
        classStarter = 'c';
        currentGroupItem = i;
      }
      var spanTags = groupList[i].getElementsByTagName("span");
      for (var ii = 0; ii < spanTags.length; ii++) {
        if (spanTags[ii].className == null) {
          continue;
        }
        var oldClass = spanTags[ii].className.match(/urrentTab.*/);
        spanTags[ii].className = classStarter + oldClass;
      }
    }
    var menuHandle = moduleGroups[tabNum];
    var parentMenu = groupList[currentGroupItem];
    if (menuHandle && parentMenu) {
      updateSubmenuPosition(menuHandle, parentMenu);
    }
  };
  for (var i = 0; i < moduleLinks.length; i++) {
    moduleLinks[i].onmouseover = moduleLinkMouseOver;
  }
};
function updateSubmenuPosition(menuHandle, parentMenu) {
  var left = '';
  if (left == "") {
    p = parentMenu;
    var left = 0;
    while (p && p.tagName.toUpperCase() != 'BODY') {
      left += p.offsetLeft;
      p = p.offsetParent;
    }
  }
  var bw = checkBrowserWidth();
  if (!parentMenu) {
    return;
  }
  var groupTabLeft = left + (parentMenu.offsetWidth / 2);
  var subTabHalfLength = 0;
  var children = menuHandle.getElementsByTagName('li');
  for (var i = 0; i < children.length; i++) {
    if (children[i].className == 'subTabMore' || children[i].parentNode.className == 'cssmenu') {
      continue;
    }
    subTabHalfLength += parseInt(children[i].offsetWidth);
  }
  if (subTabHalfLength != 0) {
    subTabHalfLength = subTabHalfLength / 2;
  }
  var totalLengthInTheory = subTabHalfLength + groupTabLeft;
  if (subTabHalfLength > 0 && groupTabLeft > 0) {
    if (subTabHalfLength >= groupTabLeft) {
      left = 1;
    } else {
      left = groupTabLeft - subTabHalfLength;
    }
  }
  if (totalLengthInTheory > bw) {
    var differ = totalLengthInTheory - bw;
    left = groupTabLeft - subTabHalfLength - differ - 2;
  }
  if (left >= 0) {
    menuHandle.style.marginLeft = left + 'px';
  }
}
YAHOO.util.Event.onDOMReady(function () {
  if (document.getElementById('subModuleList')) {
    var parentMenu = false;
    var moduleListDom = document.getElementById('moduleList');
    if (moduleListDom != null) {
      var parentTabLis = moduleListDom.getElementsByTagName("li");
      var tabNum = 0;
      for (var ii = 0; ii < parentTabLis.length; ii++) {
        var spans = parentTabLis[ii].getElementsByTagName("span");
        for (var jj = 0; jj < spans.length; jj++) {
          if (spans[jj].className.match(/currentTab.*/)) {
            tabNum = ii;
          }
        }
      }
      var parentMenu = parentTabLis[tabNum];
    }
    var moduleGroups = document.getElementById('subModuleList').getElementsByTagName("span");
    for (var i = 0; i < moduleGroups.length; i++) {
      if (moduleGroups[i].className.match(/selected/)) {
        tabNum = i;
      }
    }
    var menuHandle = moduleGroups[tabNum];
    if (menuHandle && parentMenu) {
      updateSubmenuPosition(menuHandle, parentMenu);
    }
  }
});
SUGAR.themes = SUGAR.namespace("themes");
SUGAR.append(SUGAR.themes, {
  allMenuBars: {}, setModuleTabs: function (html) {
    var el = document.getElementById('ajaxHeader');
    if (el) {
      $('#ajaxHeader').html(html);
      loadSidebar();
      if ($(window).width() < 979) {
        $('#bootstrap-container').removeClass('main');
      }
    }
  }, actionMenu: function () {
    $("ul.clickMenu").each(function (index, node) {
      $(node).sugarActionMenu();
    });
  }, loadModuleList: function () {
    var nodes = YAHOO.util.Selector.query('#moduleList>div'), currMenuBar;
    this.allMenuBars = {};
    for (var i = 0; i < nodes.length; i++) {
      currMenuBar = SUGAR.themes.currMenuBar = new YAHOO.widget.MenuBar(nodes[i].id, {
        autosubmenudisplay: true,
        visible: false,
        hidedelay: 750,
        lazyload: true
      });
      currMenuBar.render();
      this.allMenuBars[nodes[i].id.substr(nodes[i].id.indexOf('_') + 1)] = currMenuBar;
      if (typeof YAHOO.util.Dom.getChildren(nodes[i]) == 'object' && YAHOO.util.Dom.getChildren(nodes[i]).shift().style.display != 'none') {
        oMenuBar = currMenuBar;
      }
    }
    YAHOO.util.Event.onAvailable('subModuleList', IKEADEBUG);
  }, setCurrentTab: function () {
  }
});
YAHOO.util.Event.onDOMReady(SUGAR.themes.loadModuleList, SUGAR.themes, true);


// Custom jQuery for theme

// Script to toggle copyright popup
$("button").click(function () {
  $("#sugarcopy").toggle();

});

var initFooterPopups = function () {
  $("#dialog, #dialog2").dialog({
    autoOpen: false,
    show: {
      effect: "blind",
      duration: 100
    },
    hide: {
      effect: "fade",
      duration: 1000
    }
  });
  $("#powered_by").click(function () {
    $("#dialog").dialog("open");
    $("#overlay").show().css({"opacity": "0.5"});
  });
  $("#admin_options").click(function () {
    $("#dialog2").dialog("open");
  });
};

// Custom JavaScript for copyright pop-ups
$(function () {
  initFooterPopups();
});

// Back to top animation
$('#backtotop').click(function (event) {
  event.preventDefault();
  $('html, body').animate({scrollTop: 0}, 500); // Scroll speed to the top
});

// Tabs jQuery for Admin panel
$(function () {
  var tabs = $("#tabs").tabs();
  tabs.find(".ui-tabs-nav").sortable({
    axis: "x",
    stop: function () {
      tabs.tabs("refresh");
    }
  });
});


// JavaScript fix to remove unrequired classes on smaller screens where sidebar is obsolete
$(window).resize(function () {
  if ($(window).width() < 979) {
    $('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 sidebar main');
  }
  if ($(window).width() > 980 && $('.sidebar').is(':visible')) {
    $('#bootstrap-container').addClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main');
  }
});

// jQuery to toggle sidebar
function loadSidebar() {
  if ($('#sidebar_container').length) {
    $('#buttontoggle').click(function () {
      $('.sidebar').toggle();
      if ($('.sidebar').is(':visible')) {
        $.cookie('sidebartoggle', 'expanded');
        $('#buttontoggle').removeClass('button-toggle-collapsed');
        $('#buttontoggle').addClass('button-toggle-expanded');
        $('#bootstrap-container').addClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2');
        $('footer').removeClass('collapsedSidebar');
        $('footer').addClass('expandedSidebar');
        $('#bootstrap-container').removeClass('collapsedSidebar');
        $('#bootstrap-container').addClass('expandedSidebar');
      }
      if ($('.sidebar').is(':hidden')) {
        $.cookie('sidebartoggle', 'collapsed');
        $('#buttontoggle').removeClass('button-toggle-expanded');
        $('#buttontoggle').addClass('button-toggle-collapsed');
        $('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 col-sm-3 col-md-2 sidebar');
        $('footer').removeClass('expandedSidebar');
        $('footer').addClass('collapsedSidebar');
        $('#bootstrap-container').removeClass('expandedSidebar');
        $('#bootstrap-container').addClass('collapsedSidebar');
      }
    });

    var sidebartoggle = $.cookie('sidebartoggle');
    if (sidebartoggle == 'collapsed') {
      $('.sidebar').hide();
      $('#buttontoggle').removeClass('button-toggle-expanded');
      $('#buttontoggle').addClass('button-toggle-collapsed');
      $('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 col-sm-3 col-md-2 sidebar');
      $('footer').removeClass('expandedSidebar');
      $('footer').addClass('collapsedSidebar');
      $('#bootstrap-container').removeClass('expandedSidebar');
      $('#bootstrap-container').addClass('collapsedSidebar');
    }
    else {
      $('#bootstrap-container').addClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2');
      $('#buttontoggle').removeClass('button-toggle-collapsed');
      $('#buttontoggle').addClass('button-toggle-expanded');
      $('footer').removeClass('collapsedSidebar');
      $('footer').addClass('expandedSidebar');
      $('#bootstrap-container').removeClass('collapsedSidebar');
      $('#bootstrap-container').addClass('expandedSidebar');
    }
  }
}

// Alerts Notification
$(document).ready(function () {
  $('#alert-nav').click(function () {
    $('#alert-nav #alerts').css('display', 'inherit');
  });
});

function selectTab(tab) {
  $('#content div.tab-content div.tab-pane-NOBOOTSTRAPTOGGLER').hide();
  $('#content div.tab-content div.tab-pane-NOBOOTSTRAPTOGGLER').eq(tab).show().addClass('active').addClass('in');
};

function changeFirstTab(src) {
  var selected = $(src).attr('id');
  var selectedHtml = $(selected.context).html();
  $('#xstab0').html(selectedHtml);

    var i = $(src).parents('li').index();
    selectTab(parseInt(i));
    return true;
}
// End of custom jQuery


// fix for tab navigation on user profile for SuiteP theme

var getParameterByName = function (name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}
var isUserProfilePage = function () {
  var module = getParameterByName('module');
  if (!module) {
    module = $('#EditView_tabs').closest('form#EditView').find('input[name="module"]').val();
  }
  if (!module) {
    if (typeof module_sugar_grp1 !== "undefined") {
      module = module_sugar_grp1;
    }
  }
  return module == 'Users';
};

var isEditViewPage = function () {
  var action = getParameterByName('action');
  if (!action) {
    action = $('#EditView_tabs').closest('form#EditView').find('input[name="page"]').val();
  }
  return action == 'EditView';
};

var isDetailViewPage = function () {
  var action = getParameterByName('action');
  if (!action) {
    action = action_sugar_grp1;
  }
  return action == 'DetailView';
};

var refreshListViewCheckbox = function (e) {
  $(e).removeClass('glyphicon-check');
  $(e).removeClass('glyphicon-unchecked');
  if ($(e).next().prop('checked')) {
    $(e).addClass('glyphicon-check');
  }
  else {
    $(e).addClass('glyphicon-unchecked');
  }
  $(e).removeClass('disabled')
  if ($(e).next().prop('disabled')) {
    $(e).addClass('disabled')
  }
};

$(function () {
  // Fix for footer position
  if ($('#bootstrap-container footer').length > 0) {
    var clazz = $('#bootstrap-container footer').attr('class');
    $('body').append('<footer class="' + clazz + '">' + $('#bootstrap-container footer').html() + '</footer>');
    $('#bootstrap-container footer').remove();
    initFooterPopups();
  }



  var hideEmptyFormCellsOnTablet = function () {
    if ($(window).width() <= 767) {
      $('div#content div#pagecontent form#EditView div.edit.view table tbody tr td').each(function (i, e) {
        $(e).find('slot').each(function (i, e) {
          if ($(e).html().trim() == '&nbsp;') {
            $(e).html('&nbsp;');
          }
        });
        if ($(e).html().trim() == '<span>&nbsp;</span>') {
          $(e).addClass('hidden');
          $(e).addClass('hiddenOnTablet');
        }
      });
    }
    else {
      $('div#content div#pagecontent form#EditView div.edit.view table tbody tr td.hidden.hiddenOnTablet').each(function (i, e) {
        $(e).removeClass('hidden');
        $(e).removeClass('hiddenOnTablet');
      });
    }
  }

  $(window).click(function () {
    hideEmptyFormCellsOnTablet();
    setTimeout(function () {
      hideEmptyFormCellsOnTablet();
    }, 500);
  });

  $(window).resize(function () {
    hideEmptyFormCellsOnTablet();
  });

  $(window).load(function () {
    hideEmptyFormCellsOnTablet();
  });

  $(document).ready(function () {
    hideEmptyFormCellsOnTablet();
  });

  setTimeout(function () {
    hideEmptyFormCellsOnTablet();
  }, 1500);

  var listViewCheckboxInit = function () {
    var checkboxesInitialized = false;
    var checkboxesInitializeInterval = false;
    var checkboxesCountdown = 100;
    var initializeBootstrapCheckboxes = function () {
      if (!checkboxesInitialized) {
        if ($('.glyphicon.bootstrap-checkbox').length == 0) {
          if (!checkboxesInitializeInterval) {
            checkboxesInitializeInterval = setInterval(function () {
              checkboxesCountdown--;
              if (checkboxesCountdown <= 0) {
                clearInterval(checkboxesInitializeInterval);
                return;
              }
              initializeBootstrapCheckboxes();
            }, 100);
          }
        } else {
          $('.glyphicon.bootstrap-checkbox').each(function (i, e) {
            $(e).removeClass('hidden');
            $(e).next().hide();
            refreshListViewCheckbox(e);
            if (!$(e).hasClass('initialized-checkbox')) {
              $(e).click(function () {
                $(this).next().click();
                refreshListViewCheckbox($(this));
              });
              $(e).addClass('initialized-checkbox');
            }
          });

          $('#selectLink > li > ul > li > a, #selectLinkTop > li > ul > li > a, #selectLinkBottom > li > ul > li > a').click(function (e) {
            e.preventDefault();
            $('.glyphicon.bootstrap-checkbox').each(function (i, e) {
              refreshListViewCheckbox(e);
            });
          });

          checkboxesInitialized = true;
          clearInterval(checkboxesInitializeInterval);
          checkboxesInitializeInterval = false;
        }
      }
    };
    initializeBootstrapCheckboxes();
  };
  setInterval(function () {
    listViewCheckboxInit();
  }, 100);

});