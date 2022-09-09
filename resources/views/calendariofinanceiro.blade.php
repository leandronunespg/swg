@extends('layout.app')

@section('content')

<link href='{{ url("/fullcalendar-5.11.0/lib/main.css") }}' rel='stylesheet' />
<style>
	#title {
		font-size: 0.3em;
	}
</style>
<div class="row">
		<div class="col-lg col-md-6 col-sm-6 mb-4">
			<div class="stats-small stats-small--1 card card-small" measurefiltervalues="[object Object]">
				<div class="card-body p-0 d-flex bg-success">
					<div class="d-flex flex-column m-auto">
						<div class="stats-small__data text-center">
							<span class="lead font-weight-bold text-white">TOTAL PAGO</span>
							<h6 class="stats-small__value count my-2 text-center text-white">{{ 'R$ '.number_format($TotalPago, 2, ',', '.') }}</h6>
							<span class="font-weight-normal text-capitalize text-white">( {{ $MesAtual }} )</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg col-md-6 col-sm-6 mb-4">
			<div class="stats-small stats-small--1 card card-small" measurefiltervalues="[object Object]">
				<div class="card-body p-0 d-flex bg-info">
					<div class="d-flex flex-column m-auto">
						<div class="stats-small__data text-center">
							<span class="lead font-weight-bold text-white">TOTAL A PAGAR</span>
							<h6 class="stats-small__value count my-2 text-center text-white">{{ 'R$ '.number_format($TotalAPagar1, 2, ',', '.') }}</h6>
							<span class="font-weight-normal text-capitalize text-white">( {{ $MesAtual }} )</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg col-md-6 col-sm-6 mb-4">
			<div class="stats-small stats-small--1 card card-small" measurefiltervalues="[object Object]">
				<div class="card-body p-0 d-flex bg-danger">
					<div class="d-flex flex-column m-auto">
						<div class="stats-small__data text-center">
							<span class="lead font-weight-bold text-white">TOTAL A PAGAR</span>
							<h6 class="stats-small__value count my-2 text-center text-white">{{ 'R$ '.number_format($TotalAPagar2, 2, ',', '.') }}</h6>
							<span class="font-weight-normal text-capitalize text-white">( {{ $MesProximo }} )</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg col-md-6 col-sm-6 mb-4">
		
			<div class="stats-small stats-small--1 card card-small" measurefiltervalues="[object Object]">
				<div class="card-body p-0 d-flex bg-warning">
					<div class="d-flex flex-column m-auto">
						<div class="stats-small__data text-center">
							<span class="lead font-weight-bold text-white">TOTAL A PAGAR</span>
							<h6 class="stats-small__value count my-2 text-center text-white">{{ 'R$ '.number_format($TotalAPagar3, 2, ',', '.') }}</h6>
							<span class="font-weight-normal text-capitalize text-white">( {{ $MesSubsequente }} )</span>
						</div>
					</div>
				</div>
			</div>
		</div>


	<div class="col-sm-12">
		<div id='calendar'></div>
	</div>
</div>
<script>
   
	document.addEventListener('DOMContentLoaded', function() {

	  var initialLocaleCode = 'pt-br';
	  var localeSelectorEl = document.getElementById('locale-selector');
	  var calendarEl = document.getElementById('calendar');
  
	  var calendar = new FullCalendar.Calendar(calendarEl, {
		headerToolbar: {
		//   left: 'prevYear,prev,next,nextYear today',
		  left: 'prevYear,prev,next,nextYear',
		  center: '',
		//  right: 'dayGridMonth,dayGridWeek,dayGridDay'
		  right: 'dayGridMonth,dayGridWeek'
		},
		initialDate: '2022-06-14',
		locale: initialLocaleCode,
		navLinks: true, // can click day/week names to navigate views
		editable: true,
		dayMaxEvents: true, // allow "more" link when too many events		
		
		events: "/Calendario/Financeiro/"
	  });
  
	  calendar.render();
	});
  
  </script>



@endsection
<script src='{{ url("/fullcalendar-5.11.0/lib/main.js") }}'></script>
<script src='{{ url("/fullcalendar-5.11.0/lib/locales-all.js") }}'></script>
<script src='{{ url("/charts/loader.js") }}'></script>

