/**
 * Created by lewis on 18/02/14.
 */



function retrievePage(page_id) {
  retrieveData(page_id);
}

function retrieveData(page_id) {
  $(".active").removeClass("active");
  $(".current").removeClass("current");
  $("#pageNum_" + page_id + "_anchor").addClass("current");
  $("#pageNum_" + page_id).addClass("active");
  $("div[id^=pageNum_]").css('display','none');
  $("#pageNum_" + page_id + "_div").css("display", "block");
  $("#pageContainer").html('<div class="container-fluid"><img src="themes/default/images/loading_home.gif" width="48" height="48" align="baseline" border="0" alt=""></div>');
  $('#dashletsDialog_mask').css('display', 'none');
  $('#dashletsDialog_c').css('display', 'none');
  $.ajax({

    url: "index.php?entryPoint=retrieve_dash_page",
    dataType: 'html',
    type: 'POST',
    data: {
      'page_id': page_id
    },

    success: function (data) {
      var pageContent = data;
      outputPage(page_id, pageContent);
    },
    error: function (request, error) {
    }
  })
}

function outputPage(page_id, pageContent) {
  $('#pageContainer').html(pageContent);
}



