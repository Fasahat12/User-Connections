@extends('layouts.app')

@section('content')

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/helper.js') }}?v={{ time() }}" defer></script>
  <script src="{{ asset('js/main.js') }}?v={{ time() }}" defer></script>

  <div class="container">
    <x-network_connections :suggestionCount="$suggestionCount" :sentRequestCount="$sentRequestCount">
      @foreach ($users as $user)
      <x-suggestion :user="$user" />
      @endforeach
    </x-network_connections>
  </div>

  <script>

    var currentTabId = 'get_suggestions_btn';


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
                        url: `/user_connection/sent_requests/{{ auth()->id() }}/${offset}`,
                        dataType: 'json',
                        success: function(data){

                            let users = data.users;
                            let count = data.count;
                            $('.loaders').remove();

                            for(let i = 0; i < users.length; i++) {
                              $('#content').append(`<x-request :mode="'sent'" name='${users[i].name}' email='${users[i].email}' id='${users[i].id}' />`);
                          }

                          if(count == $('#content').children().length) {
                              $('#load_more_btn_parent').addClass('d-none');
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
                        url: `/user_connection/received_requests/{{ auth()->id() }}/${offset}`,
                        dataType: 'json',
                        success: function(data){

                            let users = data.users;
                            let count = data.count;
                            $('.loaders').remove();

                            for(let i = 0; i < users.length; i++) {
                              $('#content').append(`<x-request :mode="'received'" name='${users[i].name}' email='${users[i].email}' id='${users[i].id}' />`);
                          }

                          if(count == $('#content').children().length) {
                              $('#load_more_btn_parent').addClass('d-none');
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
            url: `/user_connection/suggestions/{{ auth()->id() }}/${offset}`,
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

    $('#load_more_btn').on('click', function(event){

        let offset = $('#content').children().length;

        if(currentTabId == 'get_sent_requests_btn') {
              getSentRequests(offset);
        } else if(currentTabId == 'get_suggestions_btn') {
              getSuggestions(offset);
        }

    });            
    
    $('#content').on('click', '[id^=create_request_btn_]', function(event){

        let elementId = $(this).attr('id');
        let receiverId = (elementId.split('_')).at(-1);
        
        $.ajax({
            type: "POST",
            url: `/user_connection/sent_requests`,
            dataType: 'json',
            data: { sender_id: {{ auth()->id() }}, receiver_id: receiverId },
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



  });

  </script>

@endsection