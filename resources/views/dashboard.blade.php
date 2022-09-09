@extends('layout.app')

@section('content')

<link href='{{ url("/fullcalendar-5.11.0/lib/main.css") }}' rel='stylesheet' />
<style>
	#title {
		font-size: 0.3em;
	}
</style>
<div class="row">
		
		<div class="col-lg-12 mb-2 ">
           <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
			            <div id="piechart_3d" style="width: 100%; height: 500px;"></div>
                    </div>

                    <div class="col-md-6 col-sm-6">
			            <table id="datatable-buttons" class="display responsive nowrap" style="width:100%">
                            <thead>
                              <tr>
                                
                                <th>Valor</th>                               
                                <th style="width: 1em">Data</th>
                              </tr>
                            </thead>
                            <tbody id="Tabela">
                              @foreach($Datas as $key => $datas)  
                              <tr>

                                <td>{{ number_format($datas,2,',','.') }}</td>
                                <td>{{ $key }}</td>
                              </tr>
                              @endforeach
                            </tbody>
                        </table>                        
                    </div>
                </div>
            </div>
           </div>
		</div>
	
    
        <div class="col-lg-12 mb-2">
           <div class="card">
            <div class="card-body">
                <div class="row">
                    
                </div>
            </div>
           </div>
		</div>
</div>


<script>

      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Datas', 'Totais'],
          @php
          foreach($Datas as $key => $datas){
            echo "['".$key."', ".$datas."],";

          }
          @endphp

        ]);

        var options = {
          title: 'Relação de Despesas',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
 	
  </script>



@endsection
<script src='{{ url("/fullcalendar-5.11.0/lib/main.js") }}'></script>
<script src='{{ url("/fullcalendar-5.11.0/lib/locales-all.js") }}'></script>
<script src='{{ url("/charts/loader.js") }}'></script>

