<template>
  <div class="form-container">
    <h1>Formulir Data Personal</h1>
    <form @submit.prevent="submitForm">
      <!-- Nama -->
      <div class="form-group">
        <label for="nama">Nama:</label>
        <input id="nama" v-model="formData.nama" type="text">
      </div>
      
      <!-- NIK -->
      <div class="form-group">
        <label for="nik">NIK:</label>
        <input id="nik" v-model="formData.nik" type="number">
      </div>

      <!-- Nomor Kartu Keluarga -->
      <div class="form-group">
        <label for="nomor_kartu_keluarga">Nomor Kartu Keluarga:</label>
        <input id="nomor_kartu_keluarga" v-model="formData.nomor_kartu_keluarga" type="number">
      </div>

      <!-- Foto KTP -->
      <div class="form-group">
        <label for="foto_ktp_path">Foto KTP:</label>
        <input id="foto_ktp_path" type="file" @change="handleFileChange($event, 'fotoKTP')" accept="image/jpeg, image/png, image/bmp">
        <p v-if="errors.fotoKTP" class="text-danger">{{ errors.fotoKTP }}</p>
      </div>

      <!-- Foto Kartu Keluarga -->
      <div class="form-group">
        <label for="foto_kartu_keluarga_path">Foto Kartu Keluarga:</label>
        <input id="foto_kartu_keluarga_path" type="file" @change="handleFileChange($event, 'fotoKK')" accept="image/jpeg, image/png, image/bmp">
        <p v-if="errors.fotoKK" class="text-danger">{{ errors.fotoKK }}</p>
      </div>

      <!-- Umur -->
      <div class="form-group">
        <label for="umur">Umur:</label>
        <input id="umur" v-model="formData.umur" type="number">
      </div>

      <!-- Jenis Kelamin -->
      <div class="form-group">
        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" v-model="formData.jenis_kelamin">
          <option value="Laki-laki">Laki-laki</option>
          <option value="Perempuan">Perempuan</option>
        </select>
      </div>

      <!-- Provinsi -->
      <div class="form-group">
        <label for="provinsi">Provinsi:</label>
        <select id="provinsi" v-model="selectedProvince">
          <option value="">Pilih Provinsi</option>
          <option v-for="province in provinces" :key="province.id" :value="province.id">
            {{ province.name }}
          </option>
        </select>
      </div>

      <!-- Kab/Kota -->
      <div class="form-group">
        <label for="kab_kota">Kab/Kota:</label>
        <select id="kab_kota" v-model="selectedCity">
          <option value="">Pilih Kab/Kota</option>
          <option v-for="city in cities" :key="city.id" :value="city.id">
            {{ city.name }}
          </option>
        </select>
      </div>

      <!-- Kecamatan -->
      <div class="form-group">
        <label for="kecamatan">Kecamatan:</label>
        <select id="kecamatan" v-model="selectedDistrict">
          <option value="">Pilih Kecamatan</option>
          <option v-for="district in districts" :key="district.id" :value="district.id">
            {{ district.name }}
          </option>
        </select>
      </div>

      <!-- Kelurahan/Desa -->
      <div class="form-group">
        <label for="kelurahan_desa">Kelurahan/Desa:</label>
        <select id="kelurahan_desa" v-model="selectedVillage">
          <option value="">Pilih Kelurahan/Desa</option>
          <option v-for="village in villages" :key="village.id" :value="village.id">
            {{ village.name }}
          </option>
        </select>
      </div>

      <!-- Alamat -->
      <div class="form-group">
        <label for="alamat">Alamat:</label>
        <input id="alamat" v-model="formData.alamat" type="text">
      </div>

      <!-- RT -->
      <div class="form-group">
        <label for="rt">RT:</label>
        <input id="rt" v-model="formData.rt" type="number">
      </div>

      <!-- RW -->
      <div class="form-group">
        <label for="rw">RW:</label>
        <input id="rw" v-model="formData.rw" type="number">
      </div>

      <!-- Penghasilan Sebelum Pandemi -->
      <div class="form-group">
        <label for="penghasilan_sebelum_pandemi">Penghasilan sebelum pandemi:</label>
        <input id="penghasilan_sebelum_pandemi" v-model="formData.penghasilan_sebelum_pandemi" type="number">
      </div>

      <!-- Penghasilan Setelah Pandemi -->
      <div class="form-group">
        <label for="penghasilan_setelah_pandemi">Penghasilan setelah pandemi:</label>
        <input id="penghasilan_setelah_pandemi" v-model="formData.penghasilan_setelah_pandemi" type="number">
      </div>

      <!-- Alasan Membutuhkan Bantuan -->
      <div class="form-group">
        <label for="alasan_membutuhkan_bantuan">Alasan membutuhkan bantuan:</label>
        <select id="alasan_membutuhkan_bantuan" v-model="formData.alasan_membutuhkan_bantuan">
          <option value="Kehilangan pekerjaan">Kehilangan pekerjaan</option>
          <option value="Kepala keluarga">Kepala keluarga</option>
          <option value="Tergolong fakir/miskin">Tergolong fakir/miskin</option>
          <option value="Lainnya">Lainnya</option>
        </select>
        <input v-if="formData.alasan_membutuhkan_bantuan === 'Lainnya'" v-model="formData.alasan_lainnya" type="text" placeholder="Sebutkan alasan">
      </div>

      <!-- Terms & Conditions -->
      <div class="form-group checkbox-group">
        <input id="terms" type="checkbox" v-model="termsAccepted" required>
        <label for="terms">Saya menyatakan bahwa data yang diisikan adalah benar dan siap mempertanggungjawabkan apabila ditemukan ketidaksesuaian dalam data tersebut.</label>
      </div>

      <!-- Submit Button -->
      <button type="submit">Submit</button>
    </form>

    <!-- Preview Data -->
    <div v-if="submissionStatus">
      <h2>Preview Data</h2>
      <pre>{{ formData }}</pre>
      <p>Status: {{ submissionStatus }}</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      formData: {
        nama: '',
        nik: '',
        nomor_kartu_keluarga: '',
        fotoKTP: null,
        fotoKK: null,
        umur: '',
        jenis_kelamin: '',
        alamat: '',
        rt: '',
        rw: '',
        penghasilan_sebelum_pandemi: '',
        penghasilan_setelah_pandemi: '',
        alasan_membutuhkan_bantuan: '',
        alasan_lainnya: '',
      },
      errors: {
        fotoKTP: null,
        fotoKK: null,
      },
      provinces: [],
      cities: [],
      districts: [],
      villages: [],
      selectedProvince: '',
      selectedCity: '',
      selectedDistrict: '',
      selectedVillage: '',
      termsAccepted: false,
      submissionStatus: null,
    };
  },
  async created() {
    await this.fetchProvinces();
  },
  watch: {
    selectedProvince(newProvince) {
      this.fetchCities(newProvince);
    },
    selectedCity(newCity) {
      this.fetchDistricts(newCity);
    },
    selectedDistrict(newDistrict) {
      this.fetchVillages(newDistrict);
    },
  },
  methods: {
    async fetchProvinces() {
      try {
        const response = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        if (!response.ok) throw new Error('Network response was not ok.');
        const data = await response.json();
        this.provinces = data;
      } catch (error) {
        console.error('Failed to fetch provinces:', error);
      }
    },

    async fetchCities(selectedProvince) {
      if (!selectedProvince) return;
      try {
        const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${selectedProvince}.json`);
        if (!response.ok) throw new Error(`Failed to fetch cities: ${response.statusText}`);
        this.cities = await response.json();
        this.selectedCity = '';
        this.selectedDistrict = '';
        this.selectedVillage = '';
        this.districts = [];
        this.villages = [];
      } catch (error) {
        console.error(error.message);
      }
    },

    async fetchDistricts(selectedCity) {
      if (!selectedCity) return;
      try {
        const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${selectedCity}.json`);
        if (!response.ok) throw new Error(`Failed to fetch districts: ${response.statusText}`);
        this.districts = await response.json();
        this.selectedDistrict = '';
        this.selectedVillage = '';
        this.villages = [];
      } catch (error) {
        console.error(error.message);
      }
    },

    async fetchVillages(selectedDistrict) {
      if (!selectedDistrict) return;
      try {
        const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${selectedDistrict}.json`);
        if (!response.ok) throw new Error(`Failed to fetch villages: ${response.statusText}`);
        this.villages = await response.json();
        this.selectedVillage = '';
      } catch (error) {
        console.error(error.message);
      }
    },

    handleFileChange(event, fileType) {
      const file = event.target.files[0];
      if (!file) {
        this.errors[fileType] = 'File is required.';
        return;
      }

      const validTypes = ['image/jpeg', 'image/png', 'image/bmp'];
      if (!validTypes.includes(file.type)) {
        this.errors[fileType] = 'Only image files are allowed (JPEG, PNG, BMP).';
        return;
      }

      this.errors[fileType] = null;
      this.formData[fileType] = file;
    },

    submitForm() {
      if (!this.termsAccepted) {
        this.submissionStatus = 'Please accept the terms and conditions.';
        return;
      }

      this.submissionStatus = 'Form submitted successfully!';
      // Further form processing (e.g., send data to the server) can be done here.
    },
  },
};
</script>