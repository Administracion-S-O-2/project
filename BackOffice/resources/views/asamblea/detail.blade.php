@include('componentes.header')

    <section class="container-fluid mt-3">
        <h1 class="text-center">Asamblea</h1>
        <div class="row d.flex flex-column justify-content-center align-items-center">
            <form class="col-4 card p-3">
                <div class="form mb-3"> 
                    <label for="floatingInput">Id</label>
                    <input type="text" class="form-control" name="id" placeholder="{{ $asamblea->id }}" readonly>
                </div>
                <div class="form mb-3"> 
                    <label for="floatingInput">Proposito</label>
                    <input type="text" class="form-control" name="purpose" placeholder="{{ $asamblea->purpose }}" readonly>
                </div>
                <div class="form mb-3">
                    <label for="floatingInput">Tipo</label>
                    <input type="text" class="form-control" name="type" placeholder="{{ $asamblea->type }}" readonly>
                </div>
                <div class="form mb-3">
                    <label for="floatingInput">Fecha</label>
                    <input type="text" class="form-control" name="assembly_date" placeholder="{{ $asamblea->assembly_date }}" readonly>
                </div>
            </form>
            <div class="col-4 mt-3">
                <h3>Datos de socios que asistieron</h2>
                <table class=" table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participantsLists as $participantList)
                            <tr>
                                <td> {{ $participantList->user->name }} </td>
                                <td> {{ $participantList->user->lastname }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>

@include('componentes.footer')