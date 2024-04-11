<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

// Ceca response codes

$cecaResponseCode['0'] = 'Operación aprobada';
$cecaResponseCode['1'] = 'COMUNICACION ON-LINE INCORRECTA';
$cecaResponseCode['2'] = 'ERROR AL CALCULAR FIRMA';
$cecaResponseCode['5'] = 'ERROR. Error en el SELECT COMERCIOS';
$cecaResponseCode['6'] = 'ERROR. Faltan campos obligatorios';
$cecaResponseCode['7'] = 'ERROR. MerchantID inexistente';
$cecaResponseCode['9'] = 'ERROR. No se pudo conectar a ORACLE';
$cecaResponseCode['10'] = 'ERROR. Tarjeta errónea';
$cecaResponseCode['12'] = 'FIRMA:';
$cecaResponseCode['13'] = 'OPERACION INCORRECTA';
$cecaResponseCode['14'] = 'ERROR. Error en el SELECT OPERACIONES';
$cecaResponseCode['15'] = 'ERROR. Operación inexistente';
$cecaResponseCode['16'] = 'ERROR. Operación ya anulada';
$cecaResponseCode['17'] = 'ERROR AL OBTENER CLAVE';
$cecaResponseCode['18'] = 'ERROR. El ETILL no acepta el pedido';
$cecaResponseCode['19'] = 'ERROR. Datos no numéricos';
$cecaResponseCode['20'] = 'ERROR. Datos no alfa-numéricos';
$cecaResponseCode['21'] = 'ERROR en el cálculo del MAC';
$cecaResponseCode['22'] = 'ERROR en el cálculo del MAC';
$cecaResponseCode['23'] = 'ERROR. Usuario o password no valido.';
$cecaResponseCode['24'] = 'ERROR. Tipo de moneda no valido. La operación debe realizarse en Euros.';
$cecaResponseCode['25'] = 'ERROR. Importe no Integer.';
$cecaResponseCode['26'] = 'ERROR. Operación no realizable 100.';
$cecaResponseCode['27'] = 'ERROR. Formato CVV2/CVC2 no valido.';
$cecaResponseCode['28'] = 'ERROR. Debe especificar el CVV2/CVC2 de su tarjeta.';
$cecaResponseCode['29'] = 'ERROR. CVV2 no Integer.';
$cecaResponseCode['30'] = 'ERROR. En estos momentos no es posible continuar sin cvc2/cvv2';
$cecaResponseCode['31'] = 'ERROR. ERROR en la operatoria del comercio.';
$cecaResponseCode['32'] = 'ERROR. Tipo de moneda no valido. La operación debe realizarse en Euros.';
$cecaResponseCode['33'] = 'ERROR. El comercio solo puede realizar pagos en Euros';
$cecaResponseCode['34'] = 'ERROR. Moneda o conversión no válida para esta tarjeta.';
$cecaResponseCode['35'] = 'ERROR. Moneda o conversión no valida.';
$cecaResponseCode['36'] = 'ERROR. Conversión a Euros no válida.';
$cecaResponseCode['37'] = 'ERROR. El comercio no dispone de esta opción.';
$cecaResponseCode['38'] = 'ERROR. Respuesta Errónea del Gestor de operaciones.';
$cecaResponseCode['39'] = 'ERROR. No es posible continuar con la preautorizacion.';
$cecaResponseCode['40'] = 'ERROR. Error de comunicaciones Lu ́s. No es posible finalizar la operación.';
$cecaResponseCode['41'] = 'ERROR. TimeOut SEP. No es posible finalizar la operación.';
$cecaResponseCode['42'] = 'ERROR. SEP devuelve un 20 ERROR. No es posible finalizar la operación.';
$cecaResponseCode['43'] = 'ERROR. Error inesperado. No es posible finalizar la operación.';
$cecaResponseCode['44'] = 'ERROR. Respuesta Errónea de SEP. No es posible finalizar la operación.';
$cecaResponseCode['45'] = 'ERROR. No es posible continuar con la preautorización.';
$cecaResponseCode['46'] = 'ERROR. Error en el proceso de Autentificación. No retroceda en el navegador. Debe volver al comercio y reintentar el pago.';
$cecaResponseCode['48'] = 'ERROR. Error en el proceso de Autentificación. No retroceda en el navegador. Debe volver al comercio y reintentar el pago.';
$cecaResponseCode['50'] = 'ERROR. Se recibe una respuesta negativa en la consulta del estado de la autenticación.';
$cecaResponseCode['51'] = 'ERROR. Se recibe una respuesta negativa en la consulta del estado de la autenticación.';
$cecaResponseCode['53'] = 'ERROR. Se recibe una respuesta negativa en la consulta del estado del enrolamiento. Tarjeta no enrolada.';
$cecaResponseCode['54'] = 'ERROR. Se recibe una respuesta negativa en la consulta del estado del enrolamiento y el importe supera el máximo permitido Tarjeta no enrolada.';
$cecaResponseCode['55'] = 'ERROR. Indisposición temporal remota en la consulta del estado del enrolamiento en comercio.';
$cecaResponseCode['56'] = 'ERROR. Indisposición temporal remota en la consulta del estado del enrolamiento en comercio y el importe supera el máximo permitido';
$cecaResponseCode['57'] = 'ERROR. Indisposición temporal remota en la consulta del estado del enrolamiento en comercio, y el importe supera el máximo permitid';
$cecaResponseCode['58'] = 'ERROR. Sistema remoto no responde en la consulta de estado del enrolamiento';
$cecaResponseCode['62'] = 'ERROR. El comercio tiene un filtro que no permite esta operación.(Filtro2:%d)';
$cecaResponseCode['63'] = 'ERROR. El comercio ultraseguro no acepta pagos Visa no autentificados. Póngase en contacto con su entidad.';
$cecaResponseCode['64'] = 'ERROR. El comercio ultraseguro no acepta pagos MasterCard no autentificado. Póngase en contacto con su entidad.';
$cecaResponseCode['65'] = 'ERROR. El comercio ultraseguro no acepta pagos no autentificados. Póngase en contacto con su entidad.';
$cecaResponseCode['66'] = 'ERROR. Error de proceso ultraseguro. El comercio no acepta pagos no autentificados. Póngase en contacto con su entidad.';
$cecaResponseCode['67'] = 'ERROR. Superado límite en comercio mixto.';
$cecaResponseCode['68'] = 'ERROR. Respuesta Errónea del Gestor de operaciones. Operación anulada.';
$cecaResponseCode['69'] = 'ERROR. Operatoria UCAF no valida. Póngase en contacto con su comercio o Entidad.';
$cecaResponseCode['70'] = 'El comercio tiene un filtro que no permite esta operación.Bines por países.';
$cecaResponseCode['71'] = 'Este comercio solo admite el pago con tarjetas EURO 6000.';
$cecaResponseCode['72'] = 'El comercio tiene un filtro que no permite esta operación.Gestor de Bines.';
$cecaResponseCode['73'] = 'El comercio tiene un filtro que no permite esta operación.Operaciones por día e IP.';
$cecaResponseCode['74'] = 'El comercio tiene un filtro que no permite esta operación.Operaciones por día y tarjeta.';
$cecaResponseCode['78'] = 'Token inválido.';
$cecaResponseCode['80'] = 'ERROR. Faltan campos obligatorios. MerchantID';
$cecaResponseCode['81'] = 'ERROR. Faltan campos obligatorios. AcquirerBIN';
$cecaResponseCode['82'] = 'ERROR. Faltan campos obligatorios. TerminalID';
$cecaResponseCode['83'] = 'ERROR. Faltan campos obligatorios. NumOperacion';
$cecaResponseCode['84'] = 'ERROR. Faltan campos obligatorios. Importe';
$cecaResponseCode['85'] = 'ERROR. Faltan campos obligatorios. TipoMoneda';
$cecaResponseCode['86'] = 'ERROR. Faltan campos obligatorios. Exponente';
$cecaResponseCode['87'] = 'ERROR. Faltan campos obligatorios. UrlOK';
$cecaResponseCode['88'] = 'ERROR. Faltan campos obligatorios. UrlNOK';
$cecaResponseCode['89'] = 'ERROR. Faltan campos obligatorios. Firma';
$cecaResponseCode['93'] = 'Tiempo máximo permitido para hacer la operación expirado';
$cecaResponseCode['100'] = 'Tarjeta no válida (en negativos)';
$cecaResponseCode['101'] = 'Tarjeta caducada';
$cecaResponseCode['102'] = 'Operación no realizada';
$cecaResponseCode['104'] = 'Tarjeta no válida (electrón)';
$cecaResponseCode['106'] = 'Tarjeta no válida (reintentos de PIN)';
$cecaResponseCode['111'] = 'Número de tarjeta mal tecleado (check)';
$cecaResponseCode['112'] = 'Tarjeta no válida (se exige PIN)';
$cecaResponseCode['114'] = 'No admitida la forma de pago solicitada';
$cecaResponseCode['116'] = 'Saldo insuficiente';
$cecaResponseCode['118'] = 'Tarjeta no válida (no existente en ficheros)';
$cecaResponseCode['120'] = 'Tarjeta no válida en este comercio';
$cecaResponseCode['121'] = 'Disponible sobrepasado';
$cecaResponseCode['123'] = 'Número máximo de operaciones superado';
$cecaResponseCode['125'] = 'La tarjeta todavía no es operativa';
$cecaResponseCode['180'] = 'Tarjeta no soportada por el sistema';
$cecaResponseCode['190'] = 'Operación no realizable (resto de casos)';
$cecaResponseCode['400'] = 'Anulación aceptada';
$cecaResponseCode['480'] = 'Anulación por TO aceptada sin encontrar la operación original';
$cecaResponseCode['721'] = 'Recibido mensaje de respuesta incorrecto';
$cecaResponseCode['801'] = 'Preautorización no permitida';
$cecaResponseCode['802'] = 'Caracteres no permitidos';
$cecaResponseCode['803'] = 'Error al intentar un pago aplazado con esta tarjeta';
$cecaResponseCode['808'] = 'Existen errores en anulaciones anteriores, por el momento no permitimos volver a realizar la anulación';
$cecaResponseCode['888'] = 'Error de comunicaciones. Esta operación se encuentra bloqueada hasta que se revise su situación. Por favor vuelva a consultar su estado a partir de las 10 horas de día siguiente. Perdone las molestias.';
$cecaResponseCode['900'] = 'Devolución aceptada';
$cecaResponseCode['904'] = 'Operación no realizable (error de formato)';
$cecaResponseCode['908'] = 'Tarjeta desconocida';
$cecaResponseCode['909'] = 'Operación no realizable (error de sistema)';
$cecaResponseCode['912'] = 'Su entidad no está disponible';
$cecaResponseCode['913'] = 'Operación no realizable (clave duplicada)';
$cecaResponseCode['914'] = 'No existe la operación a anular';
$cecaResponseCode['930'] = 'Operación no realizable (Entidad merchant no válida)';
$cecaResponseCode['931'] = 'Operación no realizable (comercio no dado de alta)';
$cecaResponseCode['932'] = 'Operación no realizable (bin merchant no existe)';
$cecaResponseCode['933'] = 'Operación no realizable (sector desconocido)';
$cecaResponseCode['940'] = 'Ya recibida una anulación';
$cecaResponseCode['944'] = 'Operación no realizable (sesión no válida)';
$cecaResponseCode['948'] = 'Operación no realizable (fecha/hora inválida)';
$cecaResponseCode['950'] = 'Devolución no aceptada';
$cecaResponseCode['999'] = 'Operación no realizable (resto de casos)';
