export interface Profile {
  success: boolean;
  status: number;
  data: Data;
}

export interface Data {
  name: string;
  message: string;
}
