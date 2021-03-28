<!-- Categories Widget -->
<div class="card my-4">
    <h5 class="card-header">Statystyki</h5>
    <div class="table-responsive">
        <table id="mytable" class="table">
            <tbody>
            <tr>
                <th scope="row">Liczba użytkowników:</th>
                <td class="text-center">{{ DB::table('users')->count() }}</td>
            </tr>
            <tr>
                <th scope="row">Liczba postów:</th>
                <td class="text-center">{{ DB::table('posts')->count() }}</td>
            </tr>
            <tr>
                <th scope="row">Liczba komentarzy</th>
                <td class="text-center">{{ DB::table('comments')->count() }}</td>
            </tbody>
        </table>
    </div>
</div>


