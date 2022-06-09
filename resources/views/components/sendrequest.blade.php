<div class="d-none" id="sendrequest">
    @foreach ($sentreqlist as $user)
    <div class="my-2 shadow text-white bg-dark p-1">  
      <div class="d-flex justify-content-between">
        <table class="ms-1">
          <td class="align-middle">{{$user->name}}</td>
          <td class="align-middle"> - </td>
          <td class="align-middle">{{$user->email}}</td>
          <td class="align-middle">
        </table>
        <div>
            <button id="cancel_request_btn_" class="btn btn-danger me-1" onclick="withdrawRequest({{$user->id}})">Withdraw Request</button>
        </div>
      </div>
    </div>
    @endforeach
</div>
