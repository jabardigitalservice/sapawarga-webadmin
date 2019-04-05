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
  currentPage = 1;
  maximumPages: number;
  dataNomorPenting: NomorPenting[];
  phone_numbers = [];
  kabkota_id: number;
  kecamatan_id: number;
  kelurahan_id: number;

  constructor(
    private nomorPentingService: NomorPentingService,
    public loadingCtrl: LoadingController
  ) {
    this.dataNomorPenting = [];
    // get data kabkota
    this.kabkota_id = JSON.parse(localStorage.getItem('PROFILE')).kabkota_id;
    this.kecamatan_id = JSON.parse(localStorage.getItem('PROFILE')).kec_id;
    this.kelurahan_id = JSON.parse(localStorage.getItem('PROFILE')).kel_id;
  }

  ngOnInit() {
    this.getNomorPenting();
  }

  // get data nomor penting
  async getNomorPenting(infiniteScroll?) {
    const loader = await this.loadingCtrl.create({
      duration: 10000
    });
    if (!infiniteScroll) {
      loader.present();
    }

    this.nomorPentingService.getNomorPenting(this.currentPage).subscribe(
      res => {
        this.dataNomorPenting = this.dataNomorPenting.concat(
          res['data']['items']
        );
        // set count page
        this.maximumPages = res['data']['_meta'].pageCount;
        loader.dismiss();
        // stop infinite scroll
        if (infiniteScroll) {
          infiniteScroll.target.complete();
        }
      },
      err => {
        loader.dismiss();
      }
    );
  }

  // get data nomor penting
  async filterNomorPenting(type: string, id: number) {
    const loader = await this.loadingCtrl.create({
      duration: 10000
    });
    loader.present();

    this.nomorPentingService.filterNomorPenting(type, id).subscribe(
      res => {
        this.dataNomorPenting = res['data']['items'];
        loader.dismiss();
      },
      err => {
        loader.dismiss();
      }
    );
  }

  filterAreas(data) {
    /*
      split berdasarkan type.
      dataArea[0] = type area
      dataArea[1] = id area
    */
    let dataArea = data.split(' ');
    let typeArea = dataArea[0];
    let idArea = dataArea[1];

    this.filterNomorPenting(typeArea, idArea);
  }

  // infinite scroll
  doInfinite(event) {
    if (this.currentPage === this.maximumPages) {
      event.target.disabled = true;
    }
    // increase page
    this.currentPage++;

    setTimeout(() => {
      this.getNomorPenting(event);
    }, 2000);
  }
}
