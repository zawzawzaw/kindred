goog.provide('kindred.component.AccountContent');

goog.require('goog.events.Event');
goog.require('goog.events.EventTarget');

/**
 * The CLASSNAME constructor
 * @param {object} options The object extendable like jquery plugins
 * @param {element} element The jQuery element connected to class
 * @constructor
 * @extends {goog.events.EventTarget}
 */
kindred.component.AccountContent = function(options, element) {

  goog.events.EventTarget.call(this);
  this.options = $.extend({}, kindred.component.AccountContent.DEFAULT, options);
  this.element = element;

  this.current_tab = 'account-information';

  this.account_information_tab  = this.element.find('#page-account-information-details-tab');
  this.order_history_tab        = this.element.find('#page-account-order-history-tab');
  this.friend_referral_tab      = this.element.find('#page-account-friend-referal-tab');

    



  this.create_account_information();
  this.create_order_history();
  this.create_friend_referral();



  console.log('kindred.component.AccountContent: init');
};
goog.inherits(kindred.component.AccountContent, goog.events.EventTarget);


/**
 * like jQuery options
 * @const {object}
 */
kindred.component.AccountContent.DEFAULT = {
  'option_01': '',
  'option_02': ''
};

/**
 * CLASSNAME Event Constant
 * @const
 * @type {string}
 */
kindred.component.AccountContent.EVENT_01 = '';

/**
 * CLASSNAME Event Constant
 * @const
 * @type {string}
 */
kindred.component.AccountContent.EVENT_02 = '';


//    ____  ____  _____     ___  _____ _____
//   |  _ \|  _ \|_ _\ \   / / \|_   _| ____|
//   | |_) | |_) || | \ \ / / _ \ | | |  _|
//   |  __/|  _ < | |  \ V / ___ \| | | |___
//   |_|   |_| \_\___|  \_/_/   \_\_| |_____|
//


kindred.component.AccountContent.prototype.private_method_01 = function() {};
kindred.component.AccountContent.prototype.private_method_02 = function() {};
kindred.component.AccountContent.prototype.private_method_03 = function() {};
kindred.component.AccountContent.prototype.private_method_04 = function() {};
kindred.component.AccountContent.prototype.private_method_05 = function() {};
kindred.component.AccountContent.prototype.private_method_06 = function() {};


//     ____ ____  _____    _  _____ _____
//    / ___|  _ \| ____|  / \|_   _| ____|
//   | |   | |_) |  _|   / _ \ | | |  _|
//   | |___|  _ <| |___ / ___ \| | | |___
//    \____|_| \_\_____/_/   \_\_| |_____|
//


kindred.component.AccountContent.prototype.create_account_information = function() {


};
kindred.component.AccountContent.prototype.create_order_history = function() {


};
kindred.component.AccountContent.prototype.create_friend_referral = function() {


  $("#add-more-name").on("click", function(event){
    event.preventDefault();

    var no = $(".page-account-friend-referal-field-item").length + 1;
    var html = $(".page-account-friend-referal-field-item:first").clone()

    var newNameInputAttr = $(html).find('input.to_name').attr("name") + "_" + no;
    var newEmailInputAttr = $(html).find('input.to_email').attr("name") + "_" + no;

    $(html).find('input.to_name').attr("name", newNameInputAttr).removeAttr("required").val("");
    $(html).find('input.to_email').attr("name", newEmailInputAttr).removeAttr("required").val("");

    // var anchor = '<a href="#" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
    // $(html).find('input.to_email').after($(anchor));      

    $("#paste-clone").append($(html));

    $('#to_count').val(no);
  }.bind(this));


  /*
  $("#paste-clone").on("click", ".delete", function(e){
    e.preventDefault();

    $(this).parent().parent().remove();

    updateFields();
  });
  */
 


  var success = this.getParameterByName('success');
  var emails = this.getParameterByName('emails');

  if(success) {
    if(emails) {          
      $('#page-account-friend-referal-form-status-message').html('<div class="errors"><ul><li>The following email has already been invited!: ' + emails +'</li></ul></div>');
    } else {
      
      // $('#page-account-friend-referal-form-status-message').html('<div class="errors"><ul><li>Successfully invited.</li></ul></div>');
      $('#page-account-friend-referal-form-status-message').html('<div class="errors"><ul><li>Your friend(s) are successfully invited!</li></ul></div>');
      
    }
  }

};


//    ____  _   _ ____  _     ___ ____
//   |  _ \| | | | __ )| |   |_ _/ ___|
//   | |_) | | | |  _ \| |    | | |
//   |  __/| |_| | |_) | |___ | | |___
//   |_|    \___/|____/|_____|___\____|
//


/**
 * @param {String} str_param
 */
kindred.component.AccountContent.prototype.set_tab = function(str_param) {

  
  if (goog.isDefAndNotNull(str_param) == false) {
    str_param = 'account-information';
  }

  switch(str_param) {
    case 'friend-referral':

      this.current_tab = 'friend-referral';
      this.account_information_tab.hide(0);
      this.order_history_tab.hide(0);
      this.friend_referral_tab.show(0);
      break;

    case 'order-history':

      this.current_tab = 'order-history';
      this.account_information_tab.hide(0);
      this.order_history_tab.show(0);
      this.friend_referral_tab.hide(0);
      break;

    case 'account-information':
    default:

      this.current_tab = 'account-information';
      this.account_information_tab.show(0);
      this.order_history_tab.hide(0);
      this.friend_referral_tab.hide(0);
      break;
  } // switch


  // select menu
  $('#page-account-header-menu ul li').removeClass('selected');
  $('#page-account-header-menu ul li[data-value="' + this.current_tab + '"]').addClass('selected');

  // select mobile menu
  $('#page-account-header-menu-mobile ul li').removeClass('selected');
  $('#page-account-header-menu-mobile ul li[data-value="' + this.current_tab + '"]').addClass('selected');
};

kindred.component.AccountContent.prototype.public_method_02 = function() {};
kindred.component.AccountContent.prototype.public_method_03 = function() {};
kindred.component.AccountContent.prototype.public_method_04 = function() {};
kindred.component.AccountContent.prototype.public_method_05 = function() {};
kindred.component.AccountContent.prototype.public_method_06 = function() {};


//    _______     _______ _   _ _____ ____
//   | ____\ \   / / ____| \ | |_   _/ ___|
//   |  _|  \ \ / /|  _| |  \| | | | \___ \
//   | |___  \ V / | |___| |\  | | |  ___) |
//   |_____|  \_/  |_____|_| \_| |_| |____/
//

/**
 * @param {object} event
 */
kindred.component.AccountContent.prototype.on_event_handler_01 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.AccountContent.prototype.on_event_handler_02 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.AccountContent.prototype.on_event_handler_03 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.AccountContent.prototype.on_event_handler_04 = function(event) {
};






kindred.component.AccountContent.prototype.sample_method_calls = function() {

  // sample override
  kindred.component.AccountContent.superClass_.method_02.call(this);

  // sample event
  this.dispatchEvent(new goog.events.Event(kindred.component.AccountContent.EVENT_01));
};




//    _   _ _____ ___ _
//   | | | |_   _|_ _| |
//   | | | | | |  | || |
//   | |_| | | |  | || |___
//    \___/  |_| |___|_____|
//

/**
 * @param  {String} name [description]
 * @param  {String} url  [description]
 * @return {String}      [description]
 */
kindred.component.AccountContent.prototype.getParameterByName = function(name, url) {
  if (!url) {
    url = window.location.href;
  }
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
};