import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { NavController, NavParams, PopoverController } from '@ionic/angular';
import { Router } from '@angular/router';

@Component({
  selector: 'app-menu-navbar',
  templateUrl: './menu-navbar.component.html',
  styleUrls: ['./menu-navbar.component.scss']
})
export class MenuNavbarComponent implements OnInit {
  constructor(
    private authService: AuthService,
    public navCtrl: NavController,
    private navParams: NavParams,
    private router: Router,
    private popover: PopoverController
  ) {
    // console.log(this.navParams.get('dataUser'));
  }

  ngOnInit() {}

  logout() {
    console.log('masuk logout');
    this.authService.logout();
    this.navCtrl.navigateRoot('/login');
    this.popover.dismiss();
  }

  editProfile() {
    // this.navCtrl.navigateForward(
    //   ['/edit-profile'],
    //   this.navParams.get('dataUser')
    // );

    this.router.navigate(['edit-profile'], {
      queryParams: this.navParams.get('dataUser')
    });
    this.popover.dismiss();
  }
}
