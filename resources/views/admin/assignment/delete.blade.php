<!-- <div class="modal fade" id="delete">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Konfirmasi Penghapusan</h3>
            <button type="button" data-dismiss="modal" class="close">&times;</button>
        </div> -->
        <form action="{{route('assignment.destroy', $assignment->id) }}" method="post">
        <div class="modal-body">
        @csrf
        @method('DELETE')
            

                <h5> Apakah Anda ingin menghapus soal </h5>
                <h4><strong> {{$assignment->question}} </strong> </h4>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"> Hapus </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </form>