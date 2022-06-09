var skeletonId = 'skeleton';
var contentId = 'content';
var skipCounter = 0;
var takeAmount = 10;

function getMoreRequests(mode) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getConnections() {
  // your code here...
  console.log('get connections');
}

function getMoreConnections() {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getConnectionsInCommon(userId, connectionId) {
  // your code here...
}

function getMoreConnectionsInCommon(userId, connectionId) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getSuggestions() {
  // your code here...
  console.log('suggestion');
}

function getMoreSuggestions() {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function sendRequest(userId, suggestionId) {
  // console.log('$(this).attr() :>> ', $(this).attr('checked'));
  
  // your code here...
    // decodeURI();
  jQuery.ajax({
      type: 'POST',
      url: window.location.origin+'/sendrequest',
      data: {"_token": $('meta[name="csrf-token"]').attr('content'), "user_id": userId},
      success: function(data) {
        $('#connectiontable').html(data);
      }
  });
}

function deleteRequest(userId, requestId) {
  // your code here...
}

function acceptRequest(userId) {
  jQuery.ajax({
      type: 'POST',
      url: window.location.origin+'/acceptrequest',
      data: {"_token": $('meta[name="csrf-token"]').attr('content'), "user_id": userId},
      success: function(data) {
        $('#connectiontable').html(data);
        $('#btnradio1').removeAttr('checked');
        $('#btnradio3').attr('checked', 'checked');
        if(($('#receiverequest').hasClass('d-none'))) $('#receiverequest').removeClass('d-none');
        $('#connection,#request,#suggestion,#sendrequest').addClass('d-none');
      }
  });
}

function removeConnection(userId, connectionId) {
    jQuery.ajax({
      type: 'POST',
      url: window.location.origin+'/removeconnection',
      data: {"_token": $('meta[name="csrf-token"]').attr('content'), "user_id": userId},
      success: function(data) {
        $('#connectiontable').html(data);
        $('#btnradio1').removeAttr('checked');
        $('#btnradio4').attr('checked', 'checked');
        if(($('#connection').hasClass('d-none'))) $('#connection').removeClass('d-none');
        $('#request,#suggestion,#receiverequest,#sendrequest').addClass('d-none');
      }
  });
}

function  withdrawRequest(userId) {
  jQuery.ajax({
      type: 'POST',
      url: window.location.origin+'/withdrawrequest',
      data: {"_token": $('meta[name="csrf-token"]').attr('content'), "user_id": userId},
      success: function(data) {
        $('#connectiontable').html(data);
        $('#btnradio1').removeAttr('checked');
        $('#btnradio2').attr('checked', 'checked');
        if(($('#sendrequest').hasClass('d-none'))) $('#sendrequest').removeClass('d-none');
        $('#connection,#suggestion,#receiverequest').addClass('d-none');
      }
  });
}

$(function () {
  jQuery.ajax({
      type: 'GET',
      url: window.location.origin+'/getsuggestion',
      success: function(users) {
        
      }
  });
  
  $('#get_suggestions_btn').on('click', function () {  //suggestion
      if(($('#suggestion').hasClass('d-none'))) $('#suggestion').removeClass('d-none');
      $('#request,#connection,#receiverequest,#sendrequest').addClass('d-none');
  });

  $('#get_sent_requests_btn').on('click', function () {  //send request
      if(($('#sendrequest').hasClass('d-none'))) $('#sendrequest').removeClass('d-none');
      $('#connection,#suggestion,#receiverequest').addClass('d-none');
  });

  $('#get_received_requests_btn').on('click', function () {  //received request
    if(($('#receiverequest').hasClass('d-none'))) $('#receiverequest').removeClass('d-none');
    $('#connection,#request,#suggestion,#sendrequest').addClass('d-none');
  });

  $('#get_connections_btn').on('click', function () {  //connectionss
      if(($('#connection').hasClass('d-none'))) $('#connection').removeClass('d-none');
      $('#request,#suggestion,#receiverequest,#sendrequest').addClass('d-none');
  });
});