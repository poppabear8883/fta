<!DOCTYPE html>
<html>
<head></head>
<body>
<h1>Message:</h1>
<p>{{$msg}}</p>

<h1>Details:</h1>
<ul>
    <li><strong>ID:</strong> {{$user->id}}</li>
    <li><strong>Name:</strong> {{$user->name}}</li>
    <li><strong>Email:</strong> {{$user->email}}</li>
    <li><strong>Bidder Number:</strong> {{$user->bidder_number}}</li>
    <li><strong>Phone Number:</strong> {{$user->phone_number}}</li>
    <li><strong>Timezone:</strong> {{$user->timezone}}</li>
</ul>
</body>
</html>