export interface NomorPenting {
  id: number;
  name: string;
  address: string;
  description: string;
  phone_numbers: PhoneNumbersItem[];
  kabkota_id: number;
  kec_id: null;
  kel_id: null;
  latitude: string;
  longitude: string;
  seq: number;
  cover_image_path: string;
  meta: null;
  status: number;
  status_label: string;
  created_at: number;
  updated_at: number;
}

interface PhoneNumbersItem {
  type: string;
  phone_number: string;
}
