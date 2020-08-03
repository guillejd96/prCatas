package com.example.decatas;

import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.content.FileProvider;

import android.os.Environment;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import java.io.File;
import java.io.IOException;
import java.net.MalformedURLException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.LinkedHashMap;
import java.util.Map;
import java.util.Objects;

public class Valorar_Cerveza extends AppCompatActivity {

    private static final int REQUEST_TAKE_PHOTO = 1;
    private String idUsuario,idCerveza,idCata,nombre;
    public TextView title;
    public EditText inputAroma,inputApariencia,inputSabor,inputCuerpo,inputBotellin;
    public String aroma,apariencia,sabor,cuerpo,botellin;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_valorar__cerveza);

        Bundle bundle = getIntent().getExtras();
        this.idUsuario = bundle.getString("id");
        this.idCerveza = bundle.getString("c");
        this.idCata = bundle.getString("ca");

        this.title = (TextView)findViewById(R.id.title);

        inputAroma = (EditText)findViewById(R.id.inputName2);
        inputApariencia = (EditText)findViewById(R.id.inputName3);
        inputSabor = (EditText)findViewById(R.id.inputName4);
        inputCuerpo = (EditText)findViewById(R.id.inputName5);
        inputBotellin = (EditText)findViewById(R.id.inputName6);

        Map<String,String> params = new LinkedHashMap<>();
        params.put("id",idCerveza);
        Connection con = null;
        try {
            con = new Connection(getApplicationContext(),"getNombreCerveza.php",params);
            while(con.getRes()==null);
            this.nombre = con.getRes();
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }

        String txt = (String) title.getText();
        txt+=" "+nombre;
        title.setText(txt);

        params = new LinkedHashMap<>();
        params.put("id",idUsuario);
        String idPersona="";
        try {
            con = new Connection(getApplicationContext(),"getIDPersona.php",params);
            while(con.getRes()==null);
             idPersona = con.getRes().toString();
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }

        params.put("p",idPersona);
        try {
            con = new Connection(getApplicationContext(),"getOpiniones.php",params);
            while(con.getRes()==null);
            String result = con.getRes();
            if(!result.equals("")){
                Log.v("Valorar",result);
                String[] c = result.split(",");
                inputAroma.setText(c[0]);
                inputApariencia.setText(c[1]);
                inputSabor.setText(c[2]);
                inputCuerpo.setText(c[3]);
                inputBotellin.setText(c[4]);
            }
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
    }

    public void saveBeer(View v) throws MalformedURLException {
        inputAroma.setBackgroundResource(R.drawable.input_normal);
        inputSabor.setBackgroundResource(R.drawable.input_normal);
        inputCuerpo.setBackgroundResource(R.drawable.input_normal);
        inputApariencia.setBackgroundResource(R.drawable.input_normal);
        inputBotellin.setBackgroundResource(R.drawable.input_normal);

        aroma = inputAroma.getText().toString();
        apariencia = inputApariencia.getText().toString();
        sabor = inputSabor.getText().toString();
        cuerpo = inputCuerpo.getText().toString();
        botellin = inputBotellin.getText().toString();

        if(aroma.equals("")){
            Toast.makeText(getApplicationContext(),"Escribe una valoración para el aroma",Toast.LENGTH_LONG).show();
            inputAroma.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(Integer.parseInt(aroma)<0 || Integer.parseInt(aroma)>10){
            Toast.makeText(getApplicationContext(),"Introduce un valor de 0 a 10",Toast.LENGTH_LONG).show();
            inputAroma.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(apariencia.equals("")){
            Toast.makeText(getApplicationContext(),"Escribe una valoración para la apariencia",Toast.LENGTH_LONG).show();
            inputApariencia.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(Integer.parseInt(apariencia)<0 || Integer.parseInt(apariencia)>10){
            Toast.makeText(getApplicationContext(),"Introduce un valor de 0 a 10",Toast.LENGTH_LONG).show();
            inputApariencia.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(sabor.equals("")){
            Toast.makeText(getApplicationContext(),"Escribe una valoración para el sabor",Toast.LENGTH_LONG).show();
            inputSabor.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(Integer.parseInt(sabor)<0 || Integer.parseInt(sabor)>10){
            Toast.makeText(getApplicationContext(),"Introduce un valor de 0 a 10",Toast.LENGTH_LONG).show();
            inputSabor.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(cuerpo.equals("")){
            Toast.makeText(getApplicationContext(),"Escribe una valoración para el cuerpo",Toast.LENGTH_LONG).show();
            inputCuerpo.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(Integer.parseInt(cuerpo)<0 || Integer.parseInt(cuerpo)>10){
            Toast.makeText(getApplicationContext(),"Introduce un valor de 0 a 10",Toast.LENGTH_LONG).show();
            inputCuerpo.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(botellin.equals("")){
            Toast.makeText(getApplicationContext(),"Escribe una valoración para el botellín",Toast.LENGTH_LONG).show();
            inputBotellin.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(Integer.parseInt(botellin)<0 || Integer.parseInt(botellin)>10){
            Toast.makeText(getApplicationContext(),"Introduce un valor de 0 a 10",Toast.LENGTH_LONG).show();
            inputBotellin.setBackgroundResource(R.drawable.input_error);
            return;
        }

        Map<String,String> params = new LinkedHashMap<>();
        params.put("idU",idUsuario);
        params.put("idC",idCerveza);
        params.put("ar",aroma);
        params.put("ap",apariencia);
        params.put("s",sabor);
        params.put("c",cuerpo);
        params.put("b",botellin);
        Connection con = new Connection(getApplicationContext(),"createValoracion.php",params);
        while(con.getRes()==null);
        String res = con.getRes();
        if(res.equals("1")){
            Intent intent = new Intent(getApplicationContext(),Cata.class);
            intent.putExtra("idUsuario",idUsuario);
            intent.putExtra("idCata",idCata);
            startActivity(intent);
        }else {
            Toast.makeText(this, "No se ha podido valorar la cerveza", Toast.LENGTH_LONG).show();
        }
    }

    @RequiresApi(api = Build.VERSION_CODES.KITKAT)
    public void dispatchTakePictureIntent(View v) throws IOException {
        Intent takePictureIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        if (takePictureIntent.resolveActivity(getPackageManager()) != null) {
            File photoFile = null;
            photoFile = createImageFile();
            if (photoFile != null) {
                Uri photoURI = FileProvider.getUriForFile(Objects.requireNonNull(getApplicationContext()),
                        BuildConfig.APPLICATION_ID + ".fileprovider",
                        photoFile);
                takePictureIntent.putExtra(MediaStore.EXTRA_OUTPUT, photoURI);
                startActivityForResult(takePictureIntent, REQUEST_TAKE_PHOTO);
                Bitmap bitmap = MediaStore.Images.Media.getBitmap(this.getContentResolver(), photoURI);
            }
        }
    }

    String currentPhotoPath;

    private File createImageFile() throws IOException {
        String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss").format(new Date());
        String imageFileName = "JPEG_" + timeStamp + "_";
        File storageDir = getExternalFilesDir(Environment.DIRECTORY_PICTURES);
        File image = File.createTempFile(
                imageFileName,  /* prefix */
                ".jpg",         /* suffix */
                storageDir      /* directory */
        );
        currentPhotoPath = image.getAbsolutePath();
        return image;
    }
}