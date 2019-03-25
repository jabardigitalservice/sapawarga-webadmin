import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { NavController } from '@ionic/angular';

@Component({
  selector: 'app-menu-navbar',
  templateUrl: './menu-navbar.component.html',
  styleUrls: ['./menu-navbar.component.scss']
})
export class MenuNavbarComponent implements OnInit {
  constructor(
    private authService: AuthService,
    public navCtrl: NavController
  ) {}

  ngOnInit() {}

  logout() {
    console.log('masuk logout');
    this.authService.logout();
    this.navCtrl.navigateRoot('/login');
  }

  editProfile() {
    this.navCtrl.navigateForward('/edit-profile');
  }
}
