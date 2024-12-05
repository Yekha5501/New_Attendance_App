<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script></pre>
<div class="container">
<div class="row">
<div class="col-lg-12" style="margin-top: 15px;">
<div class="pull-left">
<h2>Generate And Download PDF File Using dompdf</h2>
</div>
<div class="pull-right"><a class="btn btn-primary" href="{{route('emp.index',['download'=>'pdf'])}}">Download PDF</a></div>
</div>
</div>
@foreach ($emps as $emp) @endforeach
<table class="table table-bordered">
<tbody>
<tr>
<th>Id</th>
<th>Name</th>
<th>Salary</th>
</tr>
<tr>
<td>{{ $emp->id }}</td>
<td>{{ $emp->name }}</td>
<td>{{ $emp->salary }}</td>
</tr>
</tbody>
</table>
</div>