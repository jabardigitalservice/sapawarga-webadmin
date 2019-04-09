import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import {
  LoadingController,
  ToastController,
  NavController
} from '@ionic/angular';
import { NomorPentingService } from '../../services/nomor-penting.service';
import { NomorPenting } from '../../interfaces/nomor-penting';

@Component({
  selector: 'app-detail-nomor-penting',
  templateUrl: './detail-nomor-penting.page.html',
  styleUrls: ['./detail-nomor-penting.page.scss']
})
export class DetailNomorPentingPage implements OnInit {
  id: number;
  dataNomorPenting: NomorPenting;
  constructor(
    private route: ActivatedRoute,
    private nomorPentingService: NomorPentingService,
    private loadingCtrl: LoadingController,
    private toastCtrl: ToastController,
    private navCtrl: NavController
  ) {}

  ngOnInit() {
    // get id detail instansion
    this.route.params.subscribe(params => {
      this.id = params['id'];
    });

    this.getDetailNomorPenting();
  }

  // get data nomor penting
  async getDetailNomorPenting() {
    const loader = await this.loadingCtrl.create({
      duration: 10000
    });
    loader.present();

    this.nomorPentingService.getDetailNomorPenting(this.id).subscribe(
      res => {
        this.dataNomorPenting = res['data'];
        console.log(this.dataNomorPenting);
        loader.dismiss();
      },
      err => {
        loader.dismiss();
        this.showToast(err.data.message);
        // jika data not found
        this.navCtrl.back();
      }
    );
  }

  goToMap(lat: number, long: number) {
    // console.log(`${lat}, ${long}`);
  }

  async showToast(msg: string) {
    const toast = await this.toastCtrl.create({
      message: msg,
      duration: 2000
    });
    toast.present();
  }
}
