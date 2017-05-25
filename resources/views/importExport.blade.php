<html lang="en">
<head>
	<title>Import - Export Laravel 5</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Import - Export in Excel and CSV Laravel 5</a>
			</div>
		</div>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col-3">
				<h1>Importar Associados</h1>
				<h2>IMPORTAR REL(2)</h2>

				{!! Form::open(['url' => 'importAss', 'method' => 'POST','files' => true ]) !!}

		        {!! Form::file('import_file_ass', null) !!}

				{!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}

				{!! Form::close() !!}
			</div>

			<div class="col-3">
				<h1>Importar End Associados</h1>
				<h2>IMPORTAR REL(3)</h2>

				{!! Form::open(['url' => 'importAssEnd', 'method' => 'POST','files' => true ]) !!}

		        {!! Form::file('import_file_ass_end', null) !!}

				{!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}

				{!! Form::close() !!}
			</div>

			<div class="col-3">
				<h1>Importar Veículos</h1>

				{!! Form::open(['url' => 'importVec', 'method' => 'POST','files' => true ]) !!}

		        {!! Form::file('import_file_vec', null) !!}

				{!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}

				{!! Form::close() !!}
			</div>

			<div class="col-3">
				<h1>Importar Profissões</h1>

				{!! Form::open(['url' => 'importProf', 'method' => 'POST','files' => true ]) !!}

		        {!! Form::file('import_file_prof', null) !!}

				{!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}

				{!! Form::close() !!}
			</div>

			<div class="col-3">
				<h1>Importar Tipo Veículos</h1>

				{!! Form::open(['url' => 'importTipoVeiculos', 'method' => 'POST','files' => true ]) !!}

		        {!! Form::file('import_file_tipo', null) !!}

				{!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}

				{!! Form::close() !!}
			</div>

		</div>
	</div>
</body>
</html>
