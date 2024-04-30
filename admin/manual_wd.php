<?php
include("../fungsi/koneksi.php");

?>
<style>
    ion-icon {
  font-size: 34px;
}
</style>
<?php include("header.php") ?>

<form class="formtable" id="formDeposit" style="padding-top: 60px; width: 50%; align-items: center; justify-content: center; position: absolute; text-align: left; margin-left: 5px;">
  <div class="col-sm-8">
            <h4 class="page-title"> Form Withdraw </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Manual Withdraw</li>
            </ol>
        </div>    
        <table class="table" style="border: 1px solid black;">
      <thead>
        <tr>
          <th class="table-dark" style="text-align: center;" colspan="3">MANUAL WITHDRAW</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="table-info" style="border: 1px solid black;">Username</td>
          <td>
            <input type="text" class="form-control" id="usernameInput" name="usernameInput" value="" placeholder="Username..." required>
          </td>
          <td>
            <button type="button" class="btn btn-primary" onclick="search()">Search</button>
          </td>
        </tr>
        <tr>
          <td class="table-info" style="border: 1px solid black;">Saldo Utama</td>
          <td colspan="6">
            <input style="background-color: #808080	;" type="text" class="form-control" id="saldoUtama" name="saldoUtama" value="" readonly>
          </td>
        </tr>
        <tr>
          <td class="table-info" style="border: 1px solid black;">Bank</td>
          <td colspan="6">
            <input style="background-color: #808080	;" type="text" class="form-control" id="bank" name="userBank" value="" readonly>
          </td>
        </tr>
        <tr>
          <td class="table-info" style="border: 1px solid black;">Nama Bank</td>
          <td colspan="6">
            <input style="background-color: #808080	;" type="text" class="form-control" id="namaBank" name="userNamaBank" value="" readonly>
          </td>
        </tr>
        <tr>
          <td class="table-info" style="border: 1px solid black;">Norek</td>
          <td colspan="6">
            <input style="background-color: #808080	;" type="text" class="form-control" id="norek" name="userNorek" value="" readonly>
          </td>
        </tr>
        <tr>
          <td class="table-info" style="border: 1px solid black;">Tujuan</td>
          <td colspan="5">
          <select id="TransferTo" name="TransferTo">
          <option value="-">-</option>
            <?php
                // Iterasi melalui opsi bank dan buat setiap opsi dalam select element
                foreach ($bankOptions as $bank => $data) {
                    $adminBank = $data["admin_bank"];
                    $adminNamaBank = $data["admin_namabank"];
                    $adminNorek = $data["admin_norek"];
                    echo "<option value=\"$adminBank\">$adminBank [ $adminNamaBank - $adminNorek]</option>";
                }
            ?>
            </select>
          </td>
        </tr>
        <tr>
          <td class="table-info" style="border: 1px solid black;">Nominal</td>
          <td colspan="6">
          <input type="number" class="form-control" id="nominalInput" name="nominalInput" placeholder="Masukan Nominal..." oninput="formatInputRupiah()" required>
          </td>
        </tr>
        <tr>
          <td class="table-info" style="border: 1px solid black;">Note Admin</td>
          <td colspan="5">
            <input type="text" class="form-control" id="noteAdmin" name="noteAdmin" placeholder="Masukan Note...">
          </td>
        </tr>
        <tr>
          <td colspan="6">
            <button type="submit" class="btn btn-success" onclick="search()">Kirim</button>
          </td>
        </tr>
      </tbody>
    </table>
</form>

<?php include("footer.php"); ?>

<script>
function search() {
  var username = document.getElementById("usernameInput").value;

  if (username) {
    fetch('../admin_realtime/realtime_member.php')
      .then(response => response.json())
      .then(data => {
        var filteredData = data.filter(item => item.username === username);

        if (filteredData.length > 0) {
          var user = filteredData[0];
          document.getElementById("namaBank").value = user.nama_bank;
          document.getElementById("bank").value = user.bank;
          document.getElementById("saldoUtama").value = formatRupiah(user.coin);
          document.getElementById("norek").value = formatNomorRekening(user.norek);
        } else {
          document.getElementById("namaBank").value = "";
          document.getElementById("bank").value = "";
          document.getElementById("saldoUtama").value = "";
          document.getElementById("norek").value = "";

          // Menampilkan notifikasi menggunakan toastr
          toastr.error("Username Tidak Ada.");
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
  } else {
    document.getElementById("namaBank").value = "";
    document.getElementById("bank").value = "";
    document.getElementById("saldoUtama").value = "";
    document.getElementById("norek").value = "";
     // Menampilkan notifikasi menggunakan toastr
     toastr.error("Username Tidak Ada.");
  }
}

document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('formDeposit').addEventListener('submit', function(event) {
    event.preventDefault(); // Mencegah form submit secara default

    var form = this;
    var formData = new FormData(form);

    fetch('../admin_realtime/proses_manual_wd.php', {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Terjadi kesalahan saat mengirim data.');
      }
      return response.text();
    })
    .then(data => {
      toastr.success('Berhasil Mengambil Saldo.');
      form.reset(); // Mengosongkan formulir setelah berhasil mengirim
    })
    .catch(error => {
      toastr.error(error.message);
    });
  });
});

  function formatNomorRekening(nomorRekening) {
  if (nomorRekening.length === 10) {
    nomorRekening = nomorRekening.substr(0, 3) + "-" + nomorRekening.substr(3, 3) + "-" + nomorRekening.substr(6);
  } else if (nomorRekening.length >= 15) {
    nomorRekening = nomorRekening.substr(0, 3) + "-" + nomorRekening.substr(3, 4) + "-" + nomorRekening.substr(7, 4) + "-" + nomorRekening.substr(11);
  } else if (nomorRekening.length >= 10) {
    nomorRekening = nomorRekening.substr(0, 3) + "-" + nomorRekening.substr(3, 3) + "-" + nomorRekening.substr(6, 4) + "-" + nomorRekening.substr(10);
  }
  return nomorRekening;
}

  function formatRupiah(nominal) {
  var rupiah = '';
  var angkarev = nominal.toString().split('').reverse().join('');
  for (var i = 0; i < angkarev.length; i++) {
    if (i % 3 === 0) {
      rupiah += angkarev.substr(i, 3) + '.';
    }
  }
  return 'Rp ' + rupiah.split('', rupiah.length - 1).reverse().join('');
}

</script>
