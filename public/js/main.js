var currentTabId = 'get_suggestions_btn';
var commonConnectionUserId = 0;


$(document).ready(function() {


  function getSentRequests(offset) {
    
    for(let i = 0; i < 10; i++) {
                      $('#content').append(`<div class="d-flex align-items-center  mb-2  text-white bg-dark p-1 shadow loaders" style="height: 45px">
                                              <strong class="ms-1 text-primary">Loading...</strong>
                                              <div class="spinner-border ms-auto text-primary me-4" role="status" aria-hidden="true"></div>
                                            </div>`);
                }

                $.ajax({
                    type: "GET",
                    url: `/user_connection/sent_requests/${authId}/${offset}`,
                    dataType: 'json',
                    success: function(data){

                        let users = data.users;
                        let count = data.count;
                        $('.loaders').remove();

                        for(let i = 0; i < users.length; i++) {
                          $('#content').append(`<div class="my-2 shadow text-white bg-dark p-1" id="sent_request_${users[i].request_id}">
                                                  <div class="d-flex justify-content-between">
                                                    <table class="ms-1">
                                                      <td class="align-middle">${users[i].name}</td>
                                                      <td class="align-middle"> - </td>
                                                      <td class="align-middle">${users[i].email}</td>
                                                      <td class="align-middle">
                                                    </table>
                                                    <div>
                                                        <button id="cancel_request_btn_${users[i].request_id}" class="btn btn-danger me-1"
                                                          onclick="">Withdraw Request</button>
                                                    </div>
                                                  </div>
                                                </div>`);
                      }

                      if(count == $('#content').children().length) {
                          $('#load_more_btn_parent').addClass('d-none');
                      } else {
                          $('#load_more_btn_parent').removeClass('d-none');
                      }
                  }
                });
  }



  function getReceivedRequests(offset) {
    
    for(let i = 0; i < 10; i++) {
                      $('#content').append(`<div class="d-flex align-items-center  mb-2  text-white bg-dark p-1 shadow loaders" style="height: 45px">
                                              <strong class="ms-1 text-primary">Loading...</strong>
                                              <div class="spinner-border ms-auto text-primary me-4" role="status" aria-hidden="true"></div>
                                            </div>`);
                }

                $.ajax({
                    type: "GET",
                    url: `/user_connection/received_requests/${authId}/${offset}`,
                    dataType: 'json',
                    success: function(data){

                        let users = data.users;
                        let count = data.count;
                        $('.loaders').remove();

                        for(let i = 0; i < users.length; i++) {
                          $('#content').append(`<div class="my-2 shadow text-white bg-dark p-1" id="sent_request_${users[i].request_id}">
                                                  <div class="d-flex justify-content-between">
                                                    <table class="ms-1">
                                                      <td class="align-middle">${users[i].name}</td>
                                                      <td class="align-middle"> - </td>
                                                      <td class="align-middle">${users[i].email}</td>
                                                      <td class="align-middle">
                                                    </table>
                                                    <div>
                                                    <button id="accept_request_btn_${users[i].request_id}" class="btn btn-primary me-1"
                                                    onclick="">Accept</button>
                                                    </div>
                                                  </div>
                                                </div>`);                     }

                      if(count == $('#content').children().length) {
                          $('#load_more_btn_parent').addClass('d-none');
                      } else {
                          $('#load_more_btn_parent').removeClass('d-none');
                      }
                  }
                });
  }


  function getSuggestions(offset) {
    for(let i = 0; i < 10; i++) {
      $('#content').append(`<div class="d-flex align-items-center  mb-2  text-white bg-dark p-1 shadow loaders" style="height: 45px">
                              <strong class="ms-1 text-primary">Loading...</strong>
                              <div class="spinner-border ms-auto text-primary me-4" role="status" aria-hidden="true"></div>
                            </div>`);
    }

    $.ajax({
        type: "GET",
        url: `/user_connection/suggestions/${authId}/${offset}`,
        dataType: 'json',
        success: function(data){

            let users = data.users;
            let count = data.count;
            $('.loaders').remove();

            for(let i = 0; i < users.length; i++) {
              $('#content').append(`<div class="my-2 shadow  text-white bg-dark p-1" id="suggestion_${users[i].id}">
                                      <div class="d-flex justify-content-between">
                                        <table class="ms-1">
                                          <td class="align-middle">${users[i].name}</td>
                                          <td class="align-middle"> - </td>
                                          <td class="align-middle">${users[i].email}</td>
                                          <td class="align-middle"> 
                                        </table>
                                        <div>
                                          <button id="create_request_btn_${users[i].id}" class="btn btn-primary me-1">Connect</button>
                                        </div>
                                      </div>
                                    </div>
                                  `);
          }

          if(count == $('#content').children().length) {
              $('#load_more_btn_parent').addClass('d-none');
          } else {
            $('#load_more_btn_parent').removeClass('d-none');
          }
      }
    });
  }

  function getConnections(offset) {
    for(let i = 0; i < 10; i++) {
      $('#content').append(`<div class="d-flex align-items-center  mb-2  text-white bg-dark p-1 shadow loaders" style="height: 45px">
                              <strong class="ms-1 text-primary">Loading...</strong>
                              <div class="spinner-border ms-auto text-primary me-4" role="status" aria-hidden="true"></div>
                            </div>`);
    }

    $.ajax({
        type: "GET",
        url: `/user_connection/connections/${authId}/${offset}`,
        dataType: 'json',
        success: function(data){

            let users = data.users;
            let count = data.count;
            let commonConnectionCounts = data.commonConnectionCounts;
            $('.loaders').remove();
            //console.log(data);

            for(let i = 0; i < users.length; i++) {
              $('#content').append(`<div class="my-2 shadow text-white bg-dark p-1" id="connection_${users[i].id}">
                                      <div class="d-flex justify-content-between">
                                        <table class="ms-1">
                                          <td class="align-middle">${users[i].name}</td>
                                          <td class="align-middle"> - </td>
                                          <td class="align-middle">${users[i].email}</td>
                                          <td class="align-middle">
                                        </table>
                                        <div>
                                          <button style="width: 220px" id="get_connections_in_common_${users[i].user_id}" class="btn btn-primary ${(commonConnectionCounts[i]==0)?'disabled':''}" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse_" aria-expanded="false" aria-controls="collapseExample">
                                            Connections in common (${commonConnectionCounts[i]})
                                          </button>
                                          <button id="remove_conn_btn_${users[i].id}" class="btn btn-danger me-1">Remove Connection</button>
                                        </div>
                                    
                                      </div>
                                    </div>  
                                  `);
          }

          if(count == $('#content').children().length) {
              $('#load_more_btn_parent').addClass('d-none');
          } else {
            $('#load_more_btn_parent').removeClass('d-none');
          }
      }
    });
  }

  function getCommonConnections(userId,offset) {
    for(let i = 0; i < 10; i++) {
      $('#content').append(`<div class="d-flex align-items-center  mb-2  text-white bg-dark p-1 shadow loaders" style="height: 45px">
                              <strong class="ms-1 text-primary">Loading...</strong>
                              <div class="spinner-border ms-auto text-primary me-4" role="status" aria-hidden="true"></div>
                            </div>`);
    }

    $.ajax({
        type: "GET",
        url: `/user_connection/connections/common/${authId}/${userId}/${offset}`,
        dataType: 'json',
        success: function(data){

            let users = data.users;
            let count = data.count;

            $('.loaders').remove();
            console.log(data);

            for(let i = 0; i < users.length; i++) {
              $('#content').append(`<div class="p-2 shadow rounded mt-2  text-white bg-dark">${users[i].name} - ${users[i].email}</div>`);
          }

          if(count == $('#content').children().length) {
              $('#load_more_btn_parent').addClass('d-none');
          } else {
            $('#load_more_btn_parent').removeClass('d-none');
          }
      }
    });
  }

  $('#get_suggestions_btn').on('click', function(event){

    let offset = 0;

    if(currentTabId != 'get_suggestions_btn') {
        currentTabId = 'get_suggestions_btn';
        $('#content').empty();
    } else {
        return;
    }

    getSuggestions(offset);

  });

  $('#get_sent_requests_btn').on('click', function(event){

              let offset = 0;

              if(currentTabId != 'get_sent_requests_btn') {
                  currentTabId = 'get_sent_requests_btn';
                  $('#content').empty();
              } else {
                  return;
              }

              getSentRequests(offset);

            });

$('#get_received_requests_btn').on('click', function(event){

          let offset = 0;

          if(currentTabId != 'get_received_requests_btn') {
              currentTabId = 'get_received_requests_btn';
              $('#content').empty();
          } else {
              return;
          }

          getReceivedRequests(offset);

});

$('#get_connections_btn').on('click', function(event){

        let offset = 0;

        if(currentTabId != 'get_connections_btn') {
            currentTabId = 'get_connections_btn';
            $('#content').empty();
        } else {
            return;
        }

        getConnections(offset);

});

$('#load_more_btn').on('click', function(event){

    let offset = $('#content').children().length;

    if(currentTabId == 'get_sent_requests_btn') {
          getSentRequests(offset);
    } else if(currentTabId == 'get_suggestions_btn') {
          getSuggestions(offset);
    } else if(currentTabId == 'get_received_requests_btn') {
          getReceivedRequests(offset);
    } else if(currentTabId == 'get_connections_btn') {
          getConnections(offset);
    } else if(currentTabId == 'get_connections_in_common') {
          getCommonConnections(commonConnectionUserId,offset)
    }
});            

$('#content').on('click', '[id^=create_request_btn_]', function(event){

    let elementId = $(this).attr('id');
    let receiverId = (elementId.split('_')).at(-1);
    
    $.ajax({
        type: "POST",
        url: `/user_connection/sent_requests`,
        dataType: 'json',
        data: { sender_id: authId, receiver_id: receiverId },
        success: function(data){
            $(`#suggestion_${receiverId}`).hide();
      }
    });

});

$('#content').on('click', '[id^=cancel_request_btn_]', function(event){

    let elementId = $(this).attr('id');
    let requestId = (elementId.split('_')).at(-1);

    $.ajax({
        type: "DELETE",
        url: `/user_connection/sent_requests/${requestId}`,
        dataType: 'json',
        success: function(data){
            $(`#sent_request_${requestId}`).hide();
      }
    });

    });


$('#content').on('click', '[id^=accept_request_btn_]', function(event){

    let elementId = $(this).attr('id');
    let requestId = (elementId.split('_')).at(-1);

    $.ajax({
        type: "POST",
        url: `/user_connection/connections`,
        dataType: 'json',
        data: {request_id:requestId},
        success: function(data){
            $(`#sent_request_${requestId}`).hide();
      }
});

});

$('#content').on('click', '[id^=remove_conn_btn_]', function(event){

  let elementId = $(this).attr('id');
  let connectionId = (elementId.split('_')).at(-1);

  $.ajax({
      type: "DELETE",
      url: `/user_connection/connections/${connectionId}`,
      dataType: 'json',
      success: function(data){
          $(`#connection_${connectionId}`).hide();
    }
});

});

$('#content').on('click', '[id^=get_connections_in_common_]', function(event){
  
  let elementId = $(this).attr('id');
  let userId = (elementId.split('_')).at(-1);
  let offset = 0;
  commonConnectionUserId = userId;

  if(currentTabId != 'get_connections_in_common') {
      currentTabId = 'get_connections_in_common';
      $('#content').empty();
  } else {
      return;
  }

  getCommonConnections(userId,offset);

});

});


