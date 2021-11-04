@extends('layouts.intranet.main')

@section('title') IndarNet - Mis Solicitudes @endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/intranet/css/misSolicitudes.css')}}">
<link rel="stylesheet" href="{{asset('plugins/bs-stepper/css/bs-stepper.min.css')}}">
@endsection

@section('body')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid text-indarBlue">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>Mis Solicitudes</h1>
                </div>
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="check" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">Ver solo pendientes</label>
                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#solicitudModal">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-indarYellow">
                            <h3 class="card-title text-indarBlue">Mis solicitudes</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No. Prospecto</th>
                                        <th>Razon Social</th>
                                        <th>Fecha de envio solicitud</th>
                                        <th>Situación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>P011098</td>
                                        <td>DIAZ GOMEZ MA DEL REFUGIO</td>
                                        <td>Feb 6, 2020, 11:37:38 AM</td>
                                        <td>Rechazada</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" id="btnInfo" matTooltip="Detalle" onclick="activeModal(1)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P026645</td>
                                        <td>HURTADO ROMO ADAIR JOSUE</td>
                                        <td>Mar 10, 2021, 1:55:49 PM</td>
                                        <td>Rechazada Credito (Aceptada Contado)</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P027121</td>
                                        <td>LA FERRETEQUILA SAS DE CV</td>
                                        <td>May 19, 2021, 5:24:05 PM</td>
                                        <td>Rechazada</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P027531</td>
                                        <td>OLIVAS MADRIGAL LUZ NOEMI</td>
                                        <td>Jun 23, 2021, 2:36:07 PM</td>
                                        <td>Rechazada Credito (Aceptada Contado)</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P028423</td>
                                        <td>ROMERO RIOS JOSE LAZARO</td>
                                        <td>Oct 26, 2018, 5:23:44 PM</td>
                                        <td>Aceptada Contado</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P021458</td>
                                        <td>MARIA GORETTI RUIZ PEREZ</td>
                                        <td>Mar 4, 2019, 10:15:27 AM</td>
                                        <td>Aceptada Contado</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P022532</td>
                                        <td>CUENCA LOPEZ ELBA</td>
                                        <td>Jul 30, 2019, 5:55:08 PM</td>
                                        <td>Aceptada Contado</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P022672</td>
                                        <td>VENTURA GATICA JOEL</td>
                                        <td>Aug 22, 2019, 12:18:48 PM</td>
                                        <td>Aceptada Contado</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P023374</td>
                                        <td>OCAMPO JAUREGUI MARIA DOLORES</td>
                                        <td>Oct 3, 2019, 8:50:36 AM</td>
                                        <td>Aceptada Contado</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P011098</td>
                                        <td>DIAZ GOMEZ MA DEL REFUGIO</td>
                                        <td>Feb 6, 2020, 11:37:38 AM</td>
                                        <td>Rechazada</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P026645</td>
                                        <td>HURTADO ROMO ADAIR JOSUE</td>
                                        <td>Mar 10, 2021, 1:55:49 PM</td>
                                        <td>Rechazada Credito (Aceptada Contado)</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P027121</td>
                                        <td>LA FERRETEQUILA SAS DE CV</td>
                                        <td>May 19, 2021, 5:24:05 PM</td>
                                        <td>Rechazada</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P027531</td>
                                        <td>OLIVAS MADRIGAL LUZ NOEMI</td>
                                        <td>Jun 23, 2021, 2:36:07 PM</td>
                                        <td>Rechazada Credito (Aceptada Contado)</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P028423</td>
                                        <td>ROMERO RIOS JOSE LAZARO</td>
                                        <td>Oct 26, 2018, 5:23:44 PM</td>
                                        <td>Aceptada Contado</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P021458</td>
                                        <td>MARIA GORETTI RUIZ PEREZ</td>
                                        <td>Mar 4, 2019, 10:15:27 AM</td>
                                        <td>Aceptada Contado</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P022532</td>
                                        <td>CUENCA LOPEZ ELBA</td>
                                        <td>Jul 30, 2019, 5:55:08 PM</td>
                                        <td>Aceptada Contado</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>P022672</td>
                                        <td>VENTURA GATICA JOEL</td>
                                        <td>Aug 22, 2019, 12:18:48 PM</td>
                                        <td>Aceptada Contado</td>
                                        <td>
                                            <div class="btn btn-info btn-circle" matTooltip="Detalle" (click)="openDetail(detailModal, element)" *ngIf="element.Status != 1">
                                                <i class="fas fa-bars"></i>
                                            </div>
                                            <div class="btn btn-primary btn-circle" matTooltip="Reenviar" (click)="initDialogQuestion(element)" *ngIf="(element.Status == 7 || element.Status == 8)"><i class="fas fa-paper-plane"></i></div>
                                            <div class="btn btn-info btn-circle" matTooltip="Historial Transacciones" (click)="initDialogTransactionHistory( element)">
                                                <i class="far fa-clock"></i>
                                            </div>
                                            <div class="btn btn-warning btn-circle" matTooltip="Continuar" (click)="Continue(content, element)" *ngIf="element.Status == 1 && !isManager()"><i class="fas fa-pencil-alt"></i></div>
                                            <div class="btn btn-danger btn-circle" matTooltip="Cancelar" (click)="initDialogQuestionCancel(element)" *ngIf="isManager() && element.Status == 10"><i class="fas fa-times"></i></div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No. Prospecto</th>
                                        <th>Razon Social</th>
                                        <th>Fecha de envio solicitud</th>
                                        <th>Situación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>

<!--MODAL ALTA SOLICITUD -->
<div class="modal fade" id="solicitudModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-indarBlue">
                <h3 class="text-center oswald title ml-auto">Solicitud para Alta de Cliente</h3>
                <h4 class="ml-auto oswald">ZONA: Z520</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-indarBlue" id="modal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h5>TIPO DE SOLICITUD</h5>
                                        <form>
                                            <label class="mr-3"><input type="radio" name="typeSoli" value="credit">Credito</label>
                                            <label class="mr-3"><input type="radio" name="typeSoli" value="creditAB">AB</label>
                                            <label class="mr-3"><input type="radio" name="typeSoli" value="cash">Contado</label>
                                            <label class="mr-3"><input type="radio" name="typeSoli" value="changeRS">Carta Responsiva</label>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-center">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-indarYellow">$</span>
                                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                            <span class="input-group-text bg-indarYellow">.00</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="bs-stepper">
                                    <div class="bs-stepper-header" role="tablist">
                                        <!-- your steps here -->
                                        <div class="step" data-target="#datosGenerales" onclick="stepper.to(1)">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-user-shield"></i></span>
                                                <span class="bs-stepper-label">Datos Generales</span>
                                            </button>
                                        </div>
                                        <div class="step" data-target="#direccionFiscal" onclick="stepper.to(2)">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-map-marker-alt"></i></span>
                                                <span class="bs-stepper-label">Dirección Fiscal</span>
                                            </button>
                                        </div>
                                        <div class="step" data-target="#negocio" onclick="stepper.to(3)">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-store"></i></span>
                                                <span class="bs-stepper-label">Negocio</span>
                                            </button>
                                        </div>
                                        <div class="step" data-target="#datosContacto" onclick="stepper.to(4)">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-address-book"></i></span>
                                                <span class="bs-stepper-label">Datos Contacto</span>
                                            </button>
                                        </div>
                                        <div class="step" data-target="#credito" onclick="stepper.to(5)">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-credit-card"></i></span>
                                                <span class="bs-stepper-label">Credito</span>
                                            </button>
                                        </div>
                                        <div class="step" data-target="#actaConstitutiva" onclick="stepper.to(6)">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-file-invoice"></i></span>
                                                <span class="bs-stepper-label">Acta constitutiva</span>
                                            </button>
                                        </div>
                                        <div class="step" data-target="#referencias" onclick="stepper.to(7)">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-users"></i></span>
                                                <span class="bs-stepper-label">Referencias</span>
                                            </button>
                                        </div>
                                        <div class="step" data-target="#final" onclick="stepper.to(8)">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle"><i class="fas fa-flag-checkered"></i></span>
                                                <span class="bs-stepper-label">Enviar</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="bs-stepper-content">
                                        <!-- your steps content here -->
                                        <div id="datosGenerales" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>DATOS GENERALES</h3>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <input type="text" name="RFC" id="rfcInput" placeholder="RFC" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="RazonSocial" id="rzInput" placeholder="Nombre o razon social" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="nombreComercial" id="nameComeInput" placeholder="Nombre Comercial" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <input type="text" name="numeroProspecto" id="prospecto" placeholder="Número de prospecto" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Constancia de Situacion Fiscal</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, ConstFileTitle);" accept="image/x-png,image/gif,image/jpeg" formControlName="RFCFileCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile01">Seleccionar Archivo...</label>
                                                    </div>
                                                </div>
                                                <small class="form-text ml-4 mb-1 text-indarBlue">Formato R1*</small>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Constancia de Situacion Fiscal (2da Pagina)</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, ConstFileTitleReverso);" accept="image/x-png,image/gif,image/jpeg" formControlName="RFCFileReversoCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile01">Seleccionar Archivo...</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Fotografia de Solicitud</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, FirmFileTitle);" accept="image/x-png,image/gif,image/jpeg" formControlName="FirmCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile01">Seleccionar Archivo...</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn bg-warning" onclick="stepper.next()">Siguiente</button>
                                        </div>
                                        <div id="direccionFiscal" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>DIRECCIÓN FISCAL</h3>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <input type="text" name="calle" id="calleInput" placeholder="Calle" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="noExt" id="noExtInput" placeholder="No. Ext" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="noInt" id="noIntInput" placeholder="No. Int" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <input type="text" name="codPos" id="cpInput" placeholder="Número de prospecto" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="email" name="emailFacturacion" id="emailFac" placeholder="Correo@exmample.com" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <button onclick="actualizarGeo()" class="btn btn-info">Actualizar GeoLocation</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Constancia de Situacion Fiscal</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, ConstFileTitle);" accept="image/x-png,image/gif,image/jpeg" formControlName="RFCFileCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile01">Seleccionar Archivo...</label>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted ml-4 mb-1">Formato R1*</small>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Constancia de Situacion Fiscal (2da Pagina)</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, ConstFileTitleReverso);" accept="image/x-png,image/gif,image/jpeg" formControlName="RFCFileReversoCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile01">Seleccionar Archivo...</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Fotografia de Solicitud</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, FirmFileTitle);" accept="image/x-png,image/gif,image/jpeg" formControlName="FirmCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile01">Seleccionar Archivo...</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-warning" onclick="stepper.previous()">Anterior</button>
                                            <button class="btn btn-warning" onclick="stepper.next()">Siguiente</button>
                                        </div>
                                        <div id="negocio" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>NEGOCIO</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="inputGroupSelect01">Giro del negocio</label>
                                                        </div>
                                                        <select class="custom-select" id="inputGroupSelect01">
                                                            <option selected>SELECCIONAR</option>
                                                            <option value="1">FABRICA</option>
                                                            <option value="2">FERRETERIA</option>
                                                            <option value="3">FERRETERIA INSDUSTRIAL</option>
                                                            <option value="4">FERRETERIA Y TLAPALERIA</option>
                                                            <option value="5">IMPERMEABILIZANTES</option>
                                                            <option value="6">INDUSTRIA</option>
                                                            <option value="7">MADERIA</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="number" name="antiguedad" id="antiguedad" placeholder="Antiguedad" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">FOTO FRENTE</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, FotoFFileTitle)" accept="image/x-png,image/gif,image/jpeg" formControlName="BusinessPic1Ctrl">
                                                        <label class="custom-file-label" for="inputGroupFile01">FotoFrente</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">FOTO PERFIL IZQ.</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, FotoIzqFileTitle)" accept="image/x-png,image/gif,image/jpeg" formControlName="BusinessPic2Ctrl">
                                                        <label class="custom-file-label" for="inputGroupFile01">FotoperfilIZq</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">FOTO PERFIL DER.</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, FotoDerFileTitle)" accept="image/x-png,image/gif,image/jpeg" formControlName="BusinessPic3Ctrl">
                                                        <label class="custom-file-label" for="inputGroupFile01">fotoPerfilDerecho</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-warning" onclick="stepper.previous()">Anterior</button>
                                            <button class="btn btn-warning" onclick="stepper.next()">Siguiente</button>
                                        </div>
                                        <div id="datosContacto" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>DATOS DE CONTACTO</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="inputGroupSelect01">Tipo de contacto</label>
                                                        </div>
                                                        <select class="custom-select" id="inputGroupSelect01">
                                                            <option selected>SELECCIONAR</option>
                                                            <option value="1">PRINCIPAL</option>
                                                            <option value="2">PAGOS</option>
                                                            <option value="3">COMPAS</option>
                                                            <option value="4">ADMON</option>
                                                            <option value="5">EMERGENCIA</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="nombreContacto" id="nombreContacto" placeholder="Nombre" class="form-control">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="telefonoContacto" id="telefonoContacto" placeholder="Telefono" class="form-control">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="celularContacto" id="celularContacto" placeholder="Celular" class="form-control">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="email" name="emailContacto" id="emailContacto" placeholder="Correo" class="form-control">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <button class="btn btn-info">Agregar Contacto</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-7">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Nombre</th>
                                                                <th scope="col">Celular</th>
                                                                <th scope="col">Tipo</th>
                                                                <th scope="col">Eliminar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Francisco</th>
                                                                <td>332255889966</td>
                                                                <td>Principal</td>
                                                                <td><i class="fas fa-user-times"></i></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Sanchez</th>
                                                                <td>3355778855</td>
                                                                <td>Pagos</td>
                                                                <td><i class="fas fa-user-times"></i></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <button class="btn btn-warning" onclick="stepper.previous()">Anterior</button>
                                            <button class="btn btn-warning" onclick="stepper.next()">Siguiente</button>
                                        </div>
                                        <div id="credito" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>CREDITO</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <p>Local:</p>
                                                    </div>
                                                    <div class="row">
                                                        <form>
                                                            <label class="mr-3"><input type="radio" name="localSoli" value="propio">Propio</label>
                                                            <label class="mr-3"><input type="radio" name="localSoli" value="rentado">Rentado</label>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>Tipo de persona</p>
                                                    <form>
                                                        <label class="mr-3"><input type="radio" name="typePeople" value="ficisa">Fisica</label>
                                                        <label class="mr-3"><input type="radio" name="typePeople" value="moral">Moral</label>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row" *ngIf="fifthFormGroup.controls.AntiquityCtrl.value<=1">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">PAGARE</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, PagareFileTitle)" accept="image/x-png,image/gif,image/jpeg" formControlName="PagareCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile01">Pagare</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">IFE/INE REPRESENTANTE</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, IFERepFileTitle)" accept="image/x-png,image/gif,image/jpeg" formControlName="IFECtrl">
                                                        <label class="custom-file-label" for="inputGroupFile01">IFE</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">IFE/INE REPRESENTANTE (Reverso)</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, IFERepFileTitleReverso)" accept="image/x-png,image/gif,image/jpeg" formControlName="IFEReversoCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile01">IFER</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" *ngIf="fifthFormGroup.controls.AntiquityCtrl.value<=1 || this.TypeRequestCtrl == 'changeRS'">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">IFE/INE AVAL</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, IFEAvalFileTitle)" accept="image/x-png,image/gif,image/jpeg" formControlName="IFEAvalCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile01">IFEA</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" *ngIf="fifthFormGroup.controls.AntiquityCtrl.value<=1 || this.TypeRequestCtrl == 'changeRS'">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">IFE/INE AVAL (Reverso)</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, IFEAvalFileTitleReverso)" accept="image/x-png,image/gif,image/jpeg" formControlName="IFEAvalReversoCtrl">
                                                        <label class="custom-file-label" for="inputGroupFile01">IFEAR</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-warning" onclick="stepper.previous()">Anterior</button>
                                            <button class="btn btn-warning" onclick="stepper.next()">Siguiente</button>
                                        </div>
                                        <div id="actaConstitutiva" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>ACTA CONSTITUTIVA</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="inputGroupSelect01">Tipo Archivo</label>
                                                        </div>
                                                        <select class="custom-select" id="inputGroupSelect01">
                                                            <option selected>SELECCIONAR</option>
                                                            <option value="1">RAZON SOCIAL</option>
                                                            <option value="2">FECHA DE CONSTITUCION</option>
                                                            <option value="3">GIRO DE LA EMPRESA</option>
                                                            <option value="3">DURACIÓN DE LA SOCIEDAD</option>
                                                            <option value="3">ACCIONISTAS</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-group input-group-sm mb-3" [formGroupName]="i">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">ACTA CONSTITUTIVA</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, ActaFileTitle[i])" accept="image/x-png,image/gif,image/jpeg" formControlName="ActaConstitutiva">
                                                            <label class="custom-file-label" for="inputGroupFile01">Acta</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <button class="btn btn-info">Agregar Documento</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-6">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Tipo</th>
                                                                <th scope="col">Documento</th>
                                                                <th scope="col">Eliminar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Razon Social</th>
                                                                <td>Razondocial.jpg</td>
                                                                <td><i class="fas fa-trash-alt"></i></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Giro empresa</th>
                                                                <td>GiroEmpresa.jpg</td>
                                                                <td><i class="fas fa-trash-alt"></i></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <button class="btn btn-warning" onclick="stepper.previous()">Anterior</button>
                                            <button class="btn btn-warning" onclick="stepper.next()">Siguiente</button>
                                        </div>
                                        <div id="referencias" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>REFERENCIAS</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <form>
                                                        <label class="mr-3"><input type="radio" name="refSoli" value="datos">Datos</label>
                                                        <label class="mr-3"><input type="radio" name="refSoli" value="caratula">Caratula</label>
                                                        <label class="mr-3"><input type="radio" name="refSoli" value="facturas">Facturas</label>
                                                    </form>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="razonSocialRef" id="razonSocialRef" placeholder="Razón Social" class="form-control">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="contactoRef" id="contactoRef" placeholder="Contacto" class="form-control">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="ciudadRef" id="ciudadRef" placeholder="Ciudad" class="form-control">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="telefonoRef" id="telefonoRef" placeholder="Telefono" class="form-control">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <button class="btn btn-info">Agregar Referencias</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-7">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Razon Social</th>
                                                                <th scope="col">Contacto</th>
                                                                <th scope="col">Ciudad</th>
                                                                <th scope="col">Telefono</th>
                                                                <th scope="col">Eliminar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td scope="row">Sierraz Sanchez</td>
                                                                <td>Contacto</td>
                                                                <td>Guadalajara</td>
                                                                <td>3322558899</td>
                                                                <td><i class="fas fa-user-times"></i></td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Ferre todo</td>
                                                                <td>Contacto</td>
                                                                <td>Tlaquepaque</td>
                                                                <td>3355778855</td>
                                                                <td><i class="fas fa-user-times"></i></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <div class="input-group input-group-sm mb-3" [formGroupName]="i">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Caratula</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, ActaFileTitle[i])" accept="image/x-png,image/gif,image/jpeg" formControlName="ActaConstitutiva">
                                                            <label class="custom-file-label" for="inputGroupFile01">Archivo ...</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <p>Las facturas deben ser de la competencia, no mayores a 30 dias y la suma del importe de estas deben ser igual o mayor al doble del credito solicitado*</p>
                                                    <div class="input-group input-group-sm mb-3" [formGroupName]="i">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Datos de Factura</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, ActaFileTitle[i])" accept="image/x-png,image/gif,image/jpeg" formControlName="ActaConstitutiva">
                                                            <label class="custom-file-label" for="inputGroupFile01">Factura</label>
                                                        </div>
                                                        <span>Ésta página debe mostrar RFC del interesado y de su proveedor*</span>
                                                    </div>
                                                    <div class="input-group input-group-sm mb-3" [formGroupName]="i">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Importe de factura</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="inputGroupFile01" (change)="onFileChange($event, ActaFileTitle[i])" accept="image/x-png,image/gif,image/jpeg" formControlName="ActaConstitutiva">
                                                            <label class="custom-file-label" for="inputGroupFile01">Factura</label>
                                                        </div>
                                                        <span>Ésta página debe mostrar el importe total de la factura*</span>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span>Importe</span>
                                                        <span class="input-group-text">$</span>
                                                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                        <span class="input-group-text">.00</span>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <button class="btn btn-info">Agregar Factura</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-6">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Datos Factura</th>
                                                                <th scope="col">Importe Factura</th>
                                                                <th scope="col">Importe</th>
                                                                <th scope="col">Eliminar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">1</th>
                                                                <td>DatosFactura.jpg</td>
                                                                <td>ImporteFactura.jpg</td>
                                                                <td>$$$</td>
                                                                <td><i class="fas fa-trash-alt"></i></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">2</th>
                                                                <td>DatosFactura.jpg</td>
                                                                <td>ImporteFactura.jpg</td>
                                                                <td>$$$</td>
                                                                <td><i class="fas fa-trash-alt"></i></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <button class="btn btn-warning" onclick="stepper.previous()">Anterior</button>
                                            <button class="btn btn-warning" onclick="stepper.next()">Siguiente</button>

                                        </div>
                                        <div id="final" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h3>SOLICITUD TERMINADA</h3>
                                                </div>
                                            </div>
                                            <button class="btn btn-warning" onclick="stepper.previous()">Anterior</button>
                                            <button type="submit" class="btn btn-success">Enviar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="row">

                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!--<div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>-->
        </div>
    </div>
</div>


<!--MODAL INFO -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{asset('asset/js/misSolicitudes.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<!-- BS-Stepper -->
<script src="{{asset('plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>


<!-- Page specific script -->

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })

    function activeModal(modal){ //if modal = 1 active login / if modal = 2 active register
        if(modal == 1){
            alert("si entra");
            var infoModal = document.getElementById('btnInfo');
            infoModal.dataToggle.add("modal");
            infoModal.dataTarget.add("#solicitudModal");
        }
    }
</script>
@endsection