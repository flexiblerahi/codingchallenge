var skeletonId = 'skeleton';
var contentId = 'content';
var skipCounter = 0;
var takeAmount = 10;

function getRequests(mode) {
    jQuery.ajax({
      type: 'POST',
      url: registerurl,
      data: formData,
      dataType: 'JSON',
      success: function(data) {
          toastr.success(data.success);
      },
      error: function(data) {
          let allerrors = null;
          if(data.responseJSON.errors) {
              allerrors = data.responseJSON.errors;
              
              if(allerrors.confirm_password) $('#confirmpassworderr').text(allerrors.confirm_password[0])
              if(allerrors.name) $('#namerr').text(allerrors.name[0])
              if(allerrors.email) $('#emailerr').text(allerrors.email[0])
              if(allerrors.password) $('#passworderr').text(allerrors.password[0])
            
          }
      }
  });
}

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

function acceptRequest(userId, requestId) {
  // your code here...
}

function removeConnection(userId, connectionId) {
  // your code here...
}

$(function () {
  // getSuggestions();
  $('#get_suggestions_btn').on('click', function () {  //suggestion
      if(($('#suggestion').hasClass('d-none'))) $('#suggestion').removeClass('d-none');
      $('#request,#connection,#receiverequest,#sendrequest').addClass('d-none');

      // getSuggestions();
  });

  $('#get_sent_requests_btn').on('click', function () {  //send request
      if(($('#sendrequest').hasClass('d-none'))) $('#sendrequest').removeClass('d-none');
      $('#connection,#suggestion,#receiverequest').addClass('d-none');

      // sendRequest();
  });

  $('#get_received_requests_btn').on('click', function () {  //received request
    if(($('#receiverequest').hasClass('d-none'))) $('#receiverequest').removeClass('d-none');
    $('#request,#suggestion,#sendrequest').addClass('d-none');
  });

  $('#get_connections_btn').on('click', function () {  //connectionss
      if(($('#connection').hasClass('d-none'))) $('#connection').removeClass('d-none');
      $('#request,#suggestion,#receiverequest,#sendrequest').addClass('d-none');
      // getConnections();
  });
});