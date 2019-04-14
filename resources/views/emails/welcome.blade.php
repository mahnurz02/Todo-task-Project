Hi <strong>{{ $name }}</strong>,
 
<p>Welcome to website, below are your credentials.</p>
<p>Username:{{$name}}
<br>
Email:{{$email}}
<br>
Password :{{$password}}
</p>
<img src="{{ url('storage/app/'.$file) }}">