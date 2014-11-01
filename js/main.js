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
    $('#report_add_error').text('');
    var text = $('#repostText').val();
    if (text === '') {
      return false;
    }
    $('#repostAddForm input[type=submit]').attr("disabled", 'disabled');
    $.post('/report/add', {text: text}, function(result) {
      result = $.parseJSON(result);
      if (result['status'] === 1) {
        $('#no_report').remove();
        $('#reportsList').prepend(result['html']);
        $('#repostText').val('');
      } else if (result['status'] === 0){
        $('#report_add_error').text(result['error']);
      }
      $('#repostAddForm input[type=submit]').removeAttr("disabled");
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

var UserList = {
  init: function() {
    $('a.user_del').bind('click', this.deleteConfirm);
    $('a.del_yes').bind('click', this.deleteConfirmYes);
    $('a.del_no').bind('click', this.deleteConfirmNo);
  },
  
  deleteConfirm: function() {
    var el = $(this);
    el.parent().parent().find('#actions').hide();
    el.parent().parent().find('#del_cnfirm').show();
    return false;
  },
  
  deleteConfirmYes: function() {
    var el = $(this);
    var id = el.parent().parent().find('input[name=userId]').val();
    $.post('/user/delete', {id: id}, function(result) {
      result = $.parseJSON(result);
      if (result['status'] === 1) {
        el.parent().parent().parent().remove();
      } else {
        el.parent().parent().find('#del_cnfirm').hide();    
        el.parent().parent().find('#actions').show();
      }
    })
    return false;
  },
  
  deleteConfirmNo: function() {
    var el = $(this);
    el.parent().parent().find('#del_cnfirm').hide();    
    el.parent().parent().find('#actions').show();
    return false;
  }
  
}

