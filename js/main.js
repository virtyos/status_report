$(function() {
  $("body").bind("ajaxSend", function (elm, xhr, s) {
    if (s.type == "POST") {
      var data = s.data;
      data += '&' + globalOptions.token_name + '=' + globalOptions.token_value + '&rev=' + new Date().getTime();
      s.data = data;
    }
  });
})

var Report = {
  init: function() {
    $('#repostText').bind('keyup', this.symbLeft);
    $('#repostAddForm').bind('submit', this.addReport);
  },
  
  
  symbLeft: function() {
    var limit = 250;
    var val = $(this).val();
    var symbCount = val.length;
    if (symbCount > limit) {
      $(this).val(val.substring(0, limit));
      return false;
    } else {
      var diff = limit - symbCount;
      $('#report_symb_left').text(diff);
    }
  },
  
  addReport: function() {
    var text = $('#repostText').val();
    $('#repostAddForm input[type=submit]').attr("disabled", 'disabled');
    $.post('/report/add', {text: text}, function(result) {
      result = $.parseJSON(result);
      if (result['status'] === 1) {
        $('#no_report').remove();
        $('#reportsList').prepend(result['html']);
        $('#repostAddForm input[type=submit]').removeAttr("disabled");
        $('#repostText').val('');
      }
    })    
    return false;
  }
}

var ReportList = {
  userId: null,
  limit: 30,
  offset: 0,
  
  stopScroll: false,
  
  init: function() {
    this.userId = globalOptions['userId'];
    var obj = this;
    $(window).scroll(function() {
      if (obj.stopScroll) {
        return;
      }
      if($(window).scrollTop() == $(document).height() - $(window).height()) {
        obj.getReports();
      }
    });
    obj.getReports();
  },
  
  getReports: function() {
    var obj = this;
    $.post('/user/getReports', {userId: this.userId, limit: this.limit, offset: this.offset}, function(result) {
      result = $.parseJSON(result);
      if (result['status'] === 1) {
        if (result['html'] == null) {
          obj.stopScroll = true;
          return false;
        }
        $('#no_report, #report_loading').remove();
        $('#reportsList').append(result['html']);
        obj.offset += obj.limit;
      }
    })
  }
}

