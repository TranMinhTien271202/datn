<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{isset($title_CV) ? $title_CV : "CV"}}</title>
	<style>
		body{
	margin: 0px;
	padding: 0px;
	background-image: radial-gradient(#c7c7c7 25%, #c7c7c7 74%);
	height: 100vh;
	font-family: system-ui;

}
.clearfix{
	clear: both;
}
.main{
	height: auto;
	width: 800px;
	background-color: white;
	box-shadow: 5px 7px 15px 5px #b9b6b6;
	margin: 20px auto;

}

.top-section{
	background-color:#151b29;
	text-align: center;
	padding: 20px;
}
.profile{
	width: 100px;
	height: 100px;
	object-fit: cover;
	border-radius: 50%;
}
.p1{
	color: white;
	font-size: 40px;
	font-weight: bold;
	margin: 0px;
	margin-top: 10px;
}
.p1 span{
	font-weight: 100;
	color: #c7c7c7;
}
.p2{
	font-size: 20px;
	color: #c7c7c7;
	margin: 0px;
	margin-top: 10px;
}
.col-div-4{
	width: 35%;
	float: left;

}
.col-div-8{
	width: 62%;
	float: left;
}
.line{
	border-left: 1px solid #c7c7c7;
  height: 800px;
  width: 2%;
  margin-top: 30px;
  float:left;
}
.content-box{
	padding: 20px;
}
.head{
	font-size: 20px;
	text-transform: uppercase;
	font-weight: 600;
}
.p3{
	color: #7b7b7b;
	margin-bottom: -5px;

}
.fa{
	color: #151b29;
}
.skills{
	margin-left: -20px;
	    margin-bottom: 0px;
}
.skills li{
	padding: 5px;
}
.skills li span{
	color: #7b7b7b;
}
.p-4{
	font-size: 14px;
	color: #7b7b7b;
}
.p-title{
	font-size: 16px;
	font-weight: bold;
}
	</style>
</head>
<body>
	<div class="main">
		<div class="top-section">
			@if($candidate->avatar != "")
			<img src="{{asset('storage/'. $candidate->avatar)}}" class="profile" />
			@endif
			<p class="p1">{{$seekerProfile->name}}</span></p>
			<p class="p2">
				@foreach($major as $mj)
				{{ $seekerProfile->major_id == $mj->id ? $mj->name : "" }}
				@endforeach
			</p>
		</div>
		<div class="clearfix"></div>

		<div class="col-div-4">
			<div class="content-box" style="padding-left: 40px;">

				
			<p class="head">Liên hệ</p>
			<p style="word-wrap: break-word;" class="p3"><i class="fa fa-phone" aria-hidden="true"></i> &nbsp;&nbsp;+{{$seekerProfile->phone}}</p>
			<p style="word-wrap: break-word;" class="p3"><i class="fa fa-envelope" aria-hidden="true"></i> &nbsp;&nbsp;{{$seekerProfile->email}}</p>
			<p style="word-wrap: break-word;" class="p3"><i class="fa fa-home" aria-hidden="true"></i> &nbsp;&nbsp;{{$seekerProfile->address}}</p>
			

			<br/>
			<p class="head">Kỹ năng</p>
			<ul class="skills">
				@foreach($list_skill as $sk)
				<li><span>{{$sk->getNameSkill->name}}</span></li>
				@endforeach

			</ul>

			<br/>
			<p class="head">Chứng chỉ</p>
			@foreach($certificates as $cer)
			<p class="p3">{{$cer->name}} - {{$cer->time}}</p>
			@endforeach

				

			<br/>
			</div>
		</div>
		<div class="line"></div>
		<div class="col-div-8">
			<div class="content-box">
			<p class="head">Mục tiêu nghề nghiệp</p>
			<p class="p3" style="font-size: 14px;line-height: 22px;">{{$seekerProfile->description}}</p>
			<br/>
			<p class="head">Kinh nghiệm</p>

			@foreach($experiences as $exp)
			<div class="box-exp" style="border-bottom: 1px solid #dbdbdbcc;width: 60%;">
				<p class="p-title">Công ty: {{$exp->company_name}} ({{date("m-Y", strtotime($exp->start_date))}} / @if($exp->end_date == null) Hiện tại @else {{date("m-Y", strtotime($exp->end_date))}} @endif)</p>
				<p>Vị trí: {{$exp->position}}</p>
				<p class="p-4">Mô tả: {{$exp->description}}</p>
			</div>
			@endforeach


			<br/>

			<p class="head">Học Vấn</p>
			@foreach($educations as $edu)
			<p class="p-title" >{{$edu->name_education}} ({{date("m-Y", strtotime($edu->start_date))}} / @if($edu->end_date == null) Hiện tại @else {{date("m-Y", strtotime($edu->end_date))}} @endif)</p>
			<div>
				@if(!empty($edu->major_id))
					@foreach($major as $mjE)
						@if($edu->major_id == $mjE->id)
						Chuyên ngành: {{$mjE->name}}
						@endif
					@endforeach
				@endif
			</div>
			<div>
				@if(!empty($edu->type_degree))
				Loại bằng: {{$edu->type_degree}}
				@endif
			</div>
			<div>
				@if(!empty($edu->gpa))
				Điểm trung bình: {{$edu->gpa}}
				@endif
			</div>
			<div>
				Mô tả: {{$edu->description}}
			</div>
			@endforeach


			</div>
		</div>

		<div class="clearfix"></div>

	</div>
</body>
</html>