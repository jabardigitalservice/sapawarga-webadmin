import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { map, catchError } from 'rxjs/operators';
import { environment } from '../../environments/environment';
import { throwError, Observable, BehaviorSubject } from 'rxjs';
import { Storage } from '@ionic/storage';
import { Platform } from '@ionic/angular';

const TOKEN_KEY = 'auth-token';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  authenticationState = new BehaviorSubject(false);

  constructor(
    private http: HttpClient,
    private storage: Storage,
    private plt: Platform
  ) {
    this.plt.ready().then(() => {
      this.checkToken();
    });
  }

  checkToken() {
    console.log(localStorage.getItem(TOKEN_KEY));
    if (localStorage.getItem(TOKEN_KEY)) {
      this.authenticationState.next(true);
    }
    // this.storage.get(TOKEN_KEY).then(res => {
    //   if (res) {
    //     this.authenticationState.next(true);
    //   }
    // });
  }

  login(data): Observable<any> {
    return this.http
      .post(`${environment.API_URL}/user/login`, { LoginForm: data })
      .pipe(catchError(this.handleError));
  }

  saveToken(token: string) {
    // console.log(token);
    // this.storage.set('name', 'Max');
    localStorage.setItem(TOKEN_KEY, token);
    this.authenticationState.next(true);
    // return this.storage.set(TOKEN_KEY, token).then(() => {
    //   this.authenticationState.next(true);
    // });
  }

  logout() {
    localStorage.removeItem(TOKEN_KEY);
    this.authenticationState.next(false);
    // return this.storage.remove(TOKEN_KEY).then(() => {
    //   this.authenticationState.next(false);
    // });
  }

  isAuthenticated() {
    return this.authenticationState.value;
  }

  private handleError(error: HttpErrorResponse) {
    if (error.error instanceof ErrorEvent) {
      // A client-side or network error occurred. Handle it accordingly.
      console.error('An error occurred:', error.error.message);
    } else {
      // The backend returned an unsuccessful response code.
      // The response body may contain clues as to what went wrong,
      console.error(
        `Backend returned code ${error.status}, ` + `body was: ${error.error}`
      );
    }
    // return an observable with a user-facing error message
    return throwError(error.error);
  }

  private extractData(res: Response) {
    let body = res;
    return body || {};
  }
}
