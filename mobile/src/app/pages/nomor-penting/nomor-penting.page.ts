import { Component, OnInit } from '@angular/core';
import { NomorPentingService } from '../../services/nomor-penting.service';
import {
  LoadingController,
  ActionSheetController,
  Platform,
  ToastController
} from '@ionic/angular';
import { NomorPenting } from '../../interfaces/nomor-penting';
import { CallNumber } from '@ionic-native/call-number/ngx';

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
    public loadingCtrl: LoadingController,
    public actionSheetController: ActionSheetController,
    private platform: Platform,
    private callNumber: CallNumber,
    public toastCtrl: ToastController
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

  // open action sheet open phone number
  async openPhone(type: string, phone: any) {
    const actionSheet = await this.actionSheetController.create({
      header: 'Nomor Telepon',
      buttons: this.createButtons(type, phone)
    });
    await actionSheet.present();
  }

  // create dynamic phone numbers
  createButtons(type: string, data: any) {
    let buttons = [];
    for (var index in data) {
      // selection get only type phone
      if (type === 'call' && data[index].type === 'phone') {
        let button = {
          text: data[index].phone_number,
          icon: 'call',
          handler: () => {
            this.phoneCall(data[index].phone_number);
          }
        };
        buttons.push(button);
      } else if (type === 'message' && data[index].type === 'message') {
        // selection get only type message
        let button = {
          text: data[index].phone_number,
          icon: 'mail',
          handler: () => {
            return true;
          }
        };
        buttons.push(button);
      }
    }
    return buttons;
  }

  // call number direct to native
  phoneCall(phone: string) {
    this.platform
      .ready()
      .then(() => {
        this.callNumber
          .callNumber(phone, true)
          .then()
          .catch(err => this.showToast('Terjadi kesalahan'));
      })
      .catch(() => {
        this.showToast('Silahkan periksa kembali permission anda');
      });
  }

  // infinite scroll
  doInfinite(event) {
    if (this.currentPage === this.maximumPages) {
      event.target.disabled = true;
      return;
    }
    // increase page
    this.currentPage++;

    setTimeout(() => {
      this.getNomorPenting(event);
    }, 2000);
  }

  async showToast(msg: string) {
    const toast = await this.toastCtrl.create({
      message: msg,
      duration: 2000
    });
    toast.present();
  }
}
