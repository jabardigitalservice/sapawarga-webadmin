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

  constructor(
    private nomorPentingService: NomorPentingService,
    public loadingCtrl: LoadingController
  ) {
    this.dataNomorPenting = [];
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

  // infinite scroll
  doInfinite(event) {
    // increase page
    this.currentPage++;

    setTimeout(() => {
      this.getNomorPenting(event);

      if (this.currentPage === this.maximumPages) {
        event.target.disabled = true;
      }
    }, 2000);
  }
}
