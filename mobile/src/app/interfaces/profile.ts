export interface Profile {
  id: number;
  email: string;
  username: string;
  name: string;
  phone: string;
  address: string;
  kelurahan: Kelurahan;
  kecamatan: Kecamatan;
  kabkota: Kabkota;
  rw: number;
  photo_url: string;
  facebook: string;
  instagram: string;
  twitter: string;
}

interface Kelurahan {
  id: number;
  name: string;
}

interface Kecamatan {
  id: number;
  name: string;
}

interface Kabkota {
  id: number;
  name: string;
}
