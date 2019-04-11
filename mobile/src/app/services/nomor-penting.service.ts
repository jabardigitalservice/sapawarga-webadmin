import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { catchError } from 'rxjs/operators';
import { Observable, throwError } from 'rxjs';
import { environment } from '../../environments/environment';
import { NomorPenting } from '../interfaces/nomor-penting';

const NOMORPENTING = 'nomor-penting';
@Injectable({
  providedIn: 'root'
})
export class NomorPentingService {
  constructor(private http: HttpClient) {}

  getNomorPenting(page: number): Observable<NomorPenting[]> {
    return this.http
      .get<NomorPenting[]>(`${environment.API_URL}/phone-books?page=${page}`)
      .pipe(catchError(this.handleError));
  }

  filterNomorPenting(type: string, id: number): Observable<NomorPenting[]> {
    return this.http
      .get<NomorPenting[]>(`${environment.API_URL}/phone-books?${type}=${id}`)
      .pipe(catchError(this.handleError));
  }

  getDetailNomorPenting(id: number): Observable<NomorPenting> {
    return this.http
      .get<NomorPenting>(`${environment.API_URL}/phone-books/${id}`)
      .pipe(catchError(this.handleError));
  }

  CariNomorPenting(value: string): Observable<NomorPenting> {
    return this.http
      .get<NomorPenting>(`${environment.API_URL}/phone-books?search=${value}`)
      .pipe(catchError(this.handleError));
  }

  // save token into local storage
  saveLocalNomoPenting(data: object) {
    localStorage.setItem(NOMORPENTING, JSON.stringify(data));
  }

  // get token into local storage
  getLocalNomorPenting() {
    return localStorage.getItem(NOMORPENTING)
      ? localStorage.getItem(NOMORPENTING)
      : '';
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
}
