import { Component, OnInit } from '@angular/core';
import { NomorPentingService } from '../../services/nomor-penting.service';
import { LoadingController, ActionSheetController } from '@ionic/angular';
import { NomorPenting } from '../../interfaces/nomor-penting';

@Component({
  selector: 'app-nomor-penting',
  templateUrl: './nomor-penting.page.html',
  styleUrls: ['./nomor-penting.page.scss']
})
export class NomorPentingPage implements OnInit {
  currentPage = 0;
  maximumPages: number;
  dataNomorPenting: NomorPenting[];
  phone_numbers = [];

  constructor(
    private nomorPentingService: NomorPentingService,
    public loadingCtrl: LoadingController,
    public actionSheetController: ActionSheetController
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

  async openPhone(phone: object) {
    console.log(phone);
    const actionSheet = await this.actionSheetController.create({
      header: 'Nomor Telepon',
      buttons: [
        {
          text: 'Delete',
          role: 'destructive',
          icon: 'call',
          handler: () => {
            console.log('Delete clicked');
          }
        },
        {
          text: 'Share',
          icon: 'call',
          handler: () => {
            console.log('Share clicked');
          }
        },
        {
          text: 'Play (open modal)',
          icon: 'call',
          handler: () => {
            console.log('Play clicked');
          }
        },
        {
          text: 'Favorite',
          icon: 'call',
          handler: () => {
            console.log('Favorite clicked');
          }
        },
        {
          text: 'Cancel',
          icon: 'close',
          role: 'cancel',
          handler: () => {
            console.log('Cancel clicked');
          }
        }
      ]
    });
    await actionSheet.present();
  }
}
