import { Component, OnInit } from '@angular/core';
import { NomorPentingService } from '../../services/nomor-penting.service';
import { LoadingController } from '@ionic/angular';
import { NomorPenting } from '../../interfaces/nomor-penting';

@Component({
  selector: 'app-nomor-penting',
  templateUrl: './nomor-penting.page.html',
  styleUrls: ['./nomor-penting.page.scss']
})
export class NomorPentingPage implements OnInit {
  constructor(
    private nomorPentingService: NomorPentingService,
    public loadingCtrl: LoadingController
  ) {}

  dataNomorPenting: NomorPenting;

  ngOnInit() {
    this.getNomorPenting();
  }

  async getNomorPenting() {
    const loader = await this.loadingCtrl.create({
      duration: 10000
    });
    if (event === null) {
      loader.present();
    }
    this.nomorPentingService.getNomorPenting().subscribe(
      res => {
        this.dataNomorPenting = res['data'];
        console.log(this.dataNomorPenting);
        loader.dismiss();
      },
      err => {
        console.log(err);
        loader.dismiss();
      }
    );
  }
}
