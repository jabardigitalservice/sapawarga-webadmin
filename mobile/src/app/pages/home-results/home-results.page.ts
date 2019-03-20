import { Component } from '@angular/core';
import {
  NavController,
  AlertController,
  MenuController,
  ToastController,
  PopoverController,
  ModalController
} from '@ionic/angular';

// Modals
import { SearchFilterPage } from '../../pages/modal/search-filter/search-filter.page';
import { ImagePage } from './../modal/image/image.page';
// Call notifications test by Popover and Custom Component.
import { NotificationsComponent } from './../../components/notifications/notifications.component';
import { Pages } from 'src/app/interfaces/pages';

@Component({
  selector: 'app-home-results',
  templateUrl: './home-results.page.html',
  styleUrls: ['./home-results.page.scss']
})
export class HomeResultsPage {
  public appPages: Array<Pages>;
  searchKey = '';
  yourLocation = '123 Test Street';
  themeCover = 'assets/img/bg-home.jpg';
  logoApp = 'assets/icon/logo.png';

  constructor(
    public navCtrl: NavController,
    public menuCtrl: MenuController,
    public popoverCtrl: PopoverController,
    public alertCtrl: AlertController,
    public modalCtrl: ModalController,
    public toastCtrl: ToastController
  ) {
    this.appPages = [
      {
        title: 'E-samsat',
        url: '',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Perizinan',
        url: '',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Info harga',
        url: '',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Info lelang',
        url: '',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Survey',
        url: '',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Polling',
        url: '',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Nomor penting',
        url: '',
        icon: 'assets/icon/demo.png'
      },
      {
        title: 'Administrasi',
        url: '',
        icon: 'assets/icon/demo.png'
      }
    ];
  }

  ionViewWillEnter() {
    this.menuCtrl.enable(true);
  }

  settings() {
    this.navCtrl.navigateForward('settings');
  }

  async alertLocation() {
    const changeLocation = await this.alertCtrl.create({
      header: 'Change Location',
      message: 'Type your Address.',
      inputs: [
        {
          name: 'location',
          placeholder: 'Enter your new Location',
          type: 'text'
        }
      ],
      buttons: [
        {
          text: 'Cancel',
          handler: data => {
            console.log('Cancel clicked');
          }
        },
        {
          text: 'Change',
          handler: async data => {
            console.log('Change clicked', data);
            this.yourLocation = data.location;
            const toast = await this.toastCtrl.create({
              message: 'Location was change successfully',
              duration: 3000,
              position: 'top',
              closeButtonText: 'OK',
              showCloseButton: true
            });

            toast.present();
          }
        }
      ]
    });
    changeLocation.present();
  }

  async searchFilter() {
    const modal = await this.modalCtrl.create({
      component: SearchFilterPage
    });
    return await modal.present();
  }

  async presentImage(image: any) {
    const modal = await this.modalCtrl.create({
      component: ImagePage,
      componentProps: { value: image }
    });
    return await modal.present();
  }

  async notifications(ev: any) {
    const popover = await this.popoverCtrl.create({
      component: NotificationsComponent,
      event: ev,
      animated: true,
      showBackdrop: true
    });
    return await popover.present();
  }
}
