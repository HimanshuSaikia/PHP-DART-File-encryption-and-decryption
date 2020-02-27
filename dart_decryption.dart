import 'dart:async';
import 'dart:io';
import 'package:path/path.dart' as p;
import 'package:path_provider/path_provider.dart';
import 'package:encrypt/encrypt.dart' as enc;

Future<String> decryptFile(filePath) async{  //'filePath' contains the php encrypted video file.
    var encodedKey = 'FCAcEA0HBAoRGyALBQIeCAcaDxYWEQQPBxcXHgAFDgY=';
    var encodedIv = 'DB4gHxkcBQkKCxoRGBkaFA==';
    var encryptedBase64EncodedString = new File(filePath).readAsStringSync();
    var decoded = base64.decode(encryptedBase64EncodedString);
    final key1 = enc.Key.fromBase64(encodedKey);
    final iv = enc.IV.fromBase64(encodedIv);
    final encrypter = enc.Encrypter(enc.AES(key1, mode: enc.AESMode.cbc));
    final decrypted = encrypter.decryptBytes(enc.Encrypted(decoded), iv: iv);print("2");
    final filename = '${p.basenameWithoutExtension(filePath)}.mp4';
    final directoryName=p.dirname(filePath);
    final newFilePath=p.join(directoryName, filename);
    var newFile = new File(newFilePath);
    await newFile.writeAsBytes(decrypted);
    return newFilePath;
  }
