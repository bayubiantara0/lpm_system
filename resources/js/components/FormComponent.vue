<template>
  <div class="form-container">
    <h1>Formulir Data Personal</h1>
    <form @submit.prevent="previewData">
      <!-- Nama -->
      <div class="form-group">
        <label for="nama">Nama:</label>
        <input id="nama" v-model="formData.nama" type="text" >
      </div>
      
      <!-- NIK -->
      <div class="form-group">
        <label for="nik">NIK:</label>
        <input id="nik" v-model="formData.nik" type="number" >
      </div>

      <!-- Nomor Kartu Keluarga -->
      <div class="form-group">
        <label for="nomor_kartu_keluarga">Nomor Kartu Keluarga:</label>
        <input id="nomor_kartu_keluarga" v-model="formData.nomor_kartu_keluarga" type="number" >
      </div>

      <!-- Foto KTP -->
      <div class="form-group">
        <label for="foto_ktp_path">Foto KTP:</label>
        <input id="foto_ktp_path" type="file" @change="handleFileChange($event, formData.fotoKTP)">
        <p v-if="errors.fotoKTP" class="text-danger">{{ errors.fotoKTP }}</p>
      </div>

      <!-- Foto Kartu Keluarga -->
      <div class="form-group">
        <label for="foto_kartu_keluarga_path">Foto Kartu Keluarga:</label>
        <input id="foto_kartu_keluarga_path" type="file" @change="handleFileChange($event, formData.fotoKK)">
        <p v-if="errors.fotoKK" class="text-danger">{{ errors.fotoKK }}</p>
      </div>

      <!-- Umur -->
      <div class="form-group">
        <label for="umur">Umur:</label>
        <input id="umur" v-model="formData.umur" type="number" >
      </div>

      <!-- Jenis Kelamin -->
      <div class="form-group">
        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" v-model="formData.jenis_kelamin" >
          <option value="Laki-laki">Laki-laki</option>
          <option value="Perempuan">Perempuan</option>
        </select>
      </div>

      <!-- Provinsi -->
      <div class="form-group">
        <label for="provinsi">Provinsi:</label>
        <select id="provinsi" v-model="selectedProvince" @change="fetchCities" >
          <option value="">Pilih Provinsi</option>
          <option v-for="province in provinces" :key="province.id" :value="province.id">
            {{ province.name }}
          </option>
        </select>
      </div>

      <!-- Kab/Kota -->
      <div class="form-group">
        <label for="kab_kota">Kab/Kota:</label>
        <select id="kab_kota" v-model="selectedCity" @change="fetchDistricts" >
          <option value="">Pilih Kab/kota</option>
          <option v-for="city in cities" :key="city.id" :value="city.id">
            {{ city.name }}
          </option>
        </select>
      </div>

      <!-- Kecamatan -->
      <div class="form-group">
        <label for="kecamatan">Kecamatan:</label>
        <select id="kecamatan" v-model="selectedDistrictes" @change="fetchVillages" >
          <option value="">Pilih Kecamatan</option>
          <option v-for="district in districtes" :key="district.id" :value="district.id">
            {{ district.name }}
          </option>
        </select>
      </div>

      <!-- Kelurahan/Desa -->
      <div class="form-group">
        <label for="kelurahan_desa">Kelurahan/Desa:</label>
        <select id="kelurahan_desa" v-model="selectedVillages" >
          <option value="">Pilih Kelurahan/Desa</option>
          <option v-for="village in villages" :key="village.id" :value="village.id">
            {{ village.name }}
          </option>
        </select>
      </div>

      <!-- Alamat -->
      <div class="form-group">
        <label for="alamat">Alamat:</label>
        <input id="alamat" v-model="formData.alamat" type="text" >
      </div>

      <!-- RT -->
      <div class="form-group">
        <label for="rt">RT:</label>
        <input id="rt" v-model="formData.rt" type="number" >
      </div>

      <!-- RW -->
      <div class="form-group">
        <label for="rw">RW:</label>
        <input id="rw" v-model="formData.rw" type="number" >
      </div>

      <!-- Penghasilan Sebelum Pandemi -->
      <div class="form-group">
        <label for="penghasilan_sebelum_pandemi">Penghasilan sebelum pandemi:</label>
        <input id="penghasilan_sebelum_pandemi" v-model="formData.penghasilan_sebelum_pandemi" type="number" >
      </div>

      <!-- Penghasilan Setelah Pandemi -->
      <div class="form-group">
        <label for="penghasilan_setelah_pandemi">Penghasilan setelah pandemi:</label>
        <input id="penghasilan_setelah_pandemi" v-model="formData.penghasilan_setelah_pandemi" type="number" >
      </div>

      <!-- Alasan Membutuhkan Bantuan -->
      <div class="form-group">
        <label for="alasan_membutuhkan_bantuan">Alasan membutuhkan bantuan:</label>
        <select id="alasan_membutuhkan_bantuan" v-model="formData.alasan_membutuhkan_bantuan" >
          <option value="Kehilangan pekerjaan">Kehilangan pekerjaan</option>
          <option value="Kepala keluarga">Kepala keluarga</option>
          <option value="Tergolong fakir/miskin">Tergolong fakir/miskin</option>
          <option value="Lainnya">Lainnya</option>
        </select>
        <input v-if="formData.alasan_membutuhkan_bantuan === 'Lainnya'" v-model="formData.alasan_lainnya" type="text" placeholder="Sebutkan alasan" >
      </div>

      <!-- Terms & Conditions -->
      <div class="form-group checkbox-group">
        <input id="terms" type="checkbox" v-model="termsAccepted" required>
        <label for="terms">Saya menyatakan bahwa data yang diisikan adalah benar dan siap mempertanggungjawabkan apabila ditemukan ketidaksesuaian dalam data tersebut.</label>
      </div>

      <!-- Preview Button -->
      <button type="submit">Lihat Preview</button>
    </form>

    <!-- Preview Data -->
    <div v-if="isPreviewVisible" class="preview-container">
      <h2>Preview Data</h2>
      <div>
        <p><strong>Nama:</strong> {{ formData.nama }}</p>
        <p><strong>NIK:</strong> {{ formData.nik }}</p>
        <p><strong>Nomor Kartu Keluarga:</strong> {{ formData.nomor_kartu_keluarga }}</p>
        <p><strong>Umur:</strong> {{ formData.umur }}</p>
        <p><strong>Jenis Kelamin:</strong> {{ formData.jenis_kelamin }}</p>
        <p><strong>Provinsi:</strong> {{ getProvinceName(selectedProvince) }}</p>
        <p><strong>Kab/Kota:</strong> {{ getCityName(selectedCity) }}</p>
        <p><strong>Kecamatan:</strong> {{ getDistrictName(selectedDistrictes) }}</p>
        <p><strong>Kelurahan/Desa:</strong> {{ getVillageName(selectedVillages) }}</p>
        <p><strong>Alamat:</strong> {{ formData.alamat }}</p>
        <p><strong>RT:</strong> {{ formData.rt }}</p>
        <p><strong>RW:</strong> {{ formData.rw }}</p>
        <p><strong>Penghasilan sebelum pandemi:</strong> {{ formData.penghasilan_sebelum_pandemi }}</p>
        <p><strong>Penghasilan setelah pandemi:</strong> {{ formData.penghasilan_setelah_pandemi }}</p>
        <p><strong>Alasan membutuhkan bantuan:</strong> {{ formData.alasan_membutuhkan_bantuan }} 
          <span v-if="formData.alasan_membutuhkan_bantuan === 'Lainnya'"> - {{ formData.alasan_lainnya }}</span>
        </p>
      </div>

      <div class="form-container">
      <!-- Tombol Submit -->
      <button @click="submitForm">Submit</button>

      <!-- Tombol Edit -->
      <button class="edit" @click="isPreviewVisible = false">Edit</button>
    </div>
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
        kecamatan: '',
        kelurahan_desa: '',
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
      districtes: [],
      villages: [],
      selectedProvince: '',
      selectedCity: '',
      selectedDistrictes: '',
      selectedVillages: '',
      isPreviewVisible: false,
      termsAccepted: false,
    };
  },
  async created() {
    await this.fetchProvinces();
  },
  watch: {
    selectedProvince(newProvince) {
      this.fetchCities(newProvince);
    },
  },
  methods: {
    async fetchProvinces() {
      try {
      const response = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
      if (!response.ok) throw new Error('Network response was not ok.');
      const data = await response.json();
      
      // console.log('Fetched Provinces Data:', data);
      
      if (Array.isArray(data)) {
        this.provinces = data;
      } else {
        console.error('Data format tidak sesuai:', data);
      }
    } catch (error) {
      console.error('Failed to fetch provinces:', error);
    }
    },

    async fetchCities(selectedProvince) {
      if (!selectedProvince) return;
      try {
        const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${this.selectedProvince}.json`);
        if (!response.ok) throw new Error(`Failed to fetch cities: ${response.statusText}`);
        this.cities = await response.json();
        this.selectedCity = ''; // Reset the selected city when province changes
      } catch (error) {
        console.error('Error fetching cities:', error);
      }
    },
    async fetchDistricts(selectedCity) {
      if (!selectedCity) return;
      try {
        const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${this.selectedCity}.json`);
        if (!response.ok) throw new Error(`Failed to fetch districtes: ${response.statusText}`);
        this.districtes = await response.json();
        this.selectedDistrictes = ''; // Reset the selected district when city changes
      } catch (error) {
        console.error('Error fetching districtes:', error);
      }
    },
    async fetchVillages(selectedDistrictes) {
      if (!selectedDistrictes) return;
      try {
        const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${this.selectedDistrictes}.json`);
        if (!response.ok) throw new Error(`Failed to fetch villages: ${response.statusText}`);
        this.villages = await response.json();
        this.selectedVillages = ''; // Reset the selected village when district changes
      } catch (error) {
        console.error('Error fetching villages:', error);
      }
    },

    handleFileChange(event, fileType) {
      const file = event.target.files[0];
      const maxSize = 2 * 1024 * 1024; // 2MB
      const allowedFormats = ['image/jpeg', 'image/png', 'image/bmp'];

      if (file) {
        this.errors[fileType] = null;

        if (file.size > maxSize) {
          this.errors[fileType] = 'File size must be less than 2MB.';
          return;
        }

        if (!allowedFormats.includes(file.type)) {
          this.errors[fileType] = 'Invalid file format. Only JPG, JPEG, PNG, and BMP are allowed.';
          return;
        }

        if (fileType === 'fotoKTP') {
          this.fotoKTP = file;
        } else if (fileType === 'fotoKK') {
          this.fotoKK = file;
        }
      }
    },

    previewData() {
      this.isPreviewVisible = true;
    },

    getProvinceName(selectedProvince) {
    // console.log('Selected Province:', selectedProvince);
    // console.log('Provinces Data:', this.provinces);
    
    const province = this.provinces.find(prov => prov.id === selectedProvince);
    return province ? province.name : '';
  },
    getCityName(selectedCity) {
      const city = this.cities.find(city => city.id === selectedCity);
      return city ? city.name : '';
    },
    getDistrictName(selectedDistrictes) {
      const district = this.districtes.find(district => district.id === selectedDistrictes);
      return district ? district.name : '';
    },
    getVillageName(selectedVillages) {
      const village = this.villages.find(village => village.id === selectedVillages);
      return village ? village.name : '';
    },

    async submitForm() {
      if (this.termsAccepted) {
        try {
          await new Promise(resolve => setTimeout(resolve, 1500));
          this.submissionStatus = 'Success';
          console.log(this.formData);
        } catch (error) {
          this.submissionStatus = 'Failed';
        }
      }
    },
  },
};
</script>
