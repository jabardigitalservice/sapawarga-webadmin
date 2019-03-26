export interface Profile {
  id: number;
  email: string;
  username: string;
  name: string;
  phone: string;
  address: string;
  kelurahan: kelurahan;
  kecamatan: kecamatan;
  kab_kota: kab_kota;
  rw: number;
}

interface kelurahan {
  id: number;
  name: string;
}

interface kecamatan {
  id: number;
  name: string;
}

interface kab_kota {
  id: number;
  name: string;
}
