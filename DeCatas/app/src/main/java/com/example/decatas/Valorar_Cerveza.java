package com.example.decatas;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.annotation.Nullable;
import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.content.FileProvider;

import android.os.Environment;
import android.provider.MediaStore;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.IOException;
import java.net.MalformedURLException;
import java.text.SimpleDateFormat;
import java.util.Arrays;
import java.util.Date;
import java.util.LinkedHashMap;
import java.util.Map;
import java.util.Objects;

public class Valorar_Cerveza extends AppCompatActivity {

    private static final int REQUEST_TAKE_PHOTO = 1;
    private static final int REQUEST_IMAGE_CAPTURE = 1;
    private String idUsuario,idCerveza,idCata,nombre,idAdmin;
    public TextView title;
    public EditText inputAroma,inputApariencia,inputSabor,inputCuerpo,inputBotellin;
    public String aroma,apariencia,sabor,cuerpo,botellin;
    public Button btnPic;
    public LinearLayout layout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_valorar__cerveza);

        Bundle bundle = getIntent().getExtras();
        this.idUsuario = bundle.getString("id");
        this.idCerveza = bundle.getString("c");
        this.idCata = bundle.getString("ca");
        this.idAdmin = bundle.getString("admin");

        this.title = (TextView)findViewById(R.id.title);

        inputAroma = (EditText)findViewById(R.id.inputName2);
        inputApariencia = (EditText)findViewById(R.id.inputName3);
        inputSabor = (EditText)findViewById(R.id.inputName4);
        inputCuerpo = (EditText)findViewById(R.id.inputName5);
        inputBotellin = (EditText)findViewById(R.id.inputName6);
        layout = (LinearLayout)findViewById(R.id.layout);
        btnPic = (Button)findViewById(R.id.button2);

        btnTakePhotoClicker b = new btnTakePhotoClicker();
        btnPic.setOnClickListener(b);


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

        if(this.idUsuario.equals(this.idAdmin)){
            ImageButton btn = new ImageButton(this);
            btn.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.FILL_PARENT,LinearLayout.LayoutParams.WRAP_CONTENT));
            btn.getLayoutParams().height=150;
            btn.getLayoutParams().width=400;
            btn.setBackgroundResource(R.drawable.buttons);
            btn.setImageResource(R.drawable.ic_delete_foreground);

            Listener l = new Listener();
            btn.setOnClickListener(l);
            btn.setVisibility(View.VISIBLE);

            layout.addView(btn);
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

    private static final int CAN_REQUEST = 1313;

    @Override
    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if(requestCode==CAN_REQUEST){
            final Bitmap bm = (Bitmap) data.getExtras().get("data");

            android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(this);
            builder.setCancelable(true);
            builder.setMessage("¿Quieres guardar esta foto?");

            ImageView img = new ImageView(this);
            img.setLayoutParams(new TableRow.LayoutParams(
                    TableRow.LayoutParams.FILL_PARENT,
                    TableRow.LayoutParams.FILL_PARENT));
            img.setImageBitmap(bm);
            img.getLayoutParams().height=500;
            img.getLayoutParams().width=250;

            builder.setView(img);

            builder.setPositiveButton(R.string.ok, new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    dialog.dismiss();

                    //ByteArrayOutputStream stream = new ByteArrayOutputStream();
                    //bm.compress(Bitmap.CompressFormat.JPEG, 100, stream);
                    //byte[] imagen = stream.toByteArray();
                    //String encodedImage = Base64.encodeToString(imagen,Base64.DEFAULT);

                //Map<String,String> p = new LinkedHashMap<>();
                //p.put("img",encodedImage);
                ///p.put("idU",idUsuario);
                //p.put("idC",idCerveza);

                    //try {
                     //   Connection c = new Connection(getApplicationContext(),"uploadImg.php",p);
                     //   while(c.getRes()==null);
                     //   if(c.getRes().equals("1")){
                     //       Toast.makeText(Valorar_Cerveza.this, "La imagen se pudo guardar", Toast.LENGTH_SHORT).show();
                     //   }else {
                     //       Toast.makeText(Valorar_Cerveza.this, "Error al guardar la imagen", Toast.LENGTH_SHORT).show();
                    //    }
                    //} catch (MalformedURLException e) {
                    //    e.printStackTrace();
                    //}

                }
            });
            builder.setNegativeButton(R.string.cancel, null);
            builder.show();
        }
    }

    private class btnTakePhotoClicker implements View.OnClickListener{

        @Override
        public void onClick(View v) {
            Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
            startActivityForResult(intent,CAN_REQUEST);
        }
    }

    private class Listener implements View.OnClickListener{

        @Override
        public void onClick(View v) {
            android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(Valorar_Cerveza.this);
            builder.setCancelable(true);
            builder.setMessage(R.string.delete_beer_from_beer_tasting);
            builder.setPositiveButton(R.string.ok, new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    Map<String,String> p = new LinkedHashMap<>();
                    p.put("id",idCerveza);
                    Connection c = null;
                    try {
                        c = new Connection(getApplicationContext(),"deleteCervezaCata.php",p);
                        while (c.getRes()==null);
                        Intent intent = new Intent(getApplicationContext(),Cata.class);
                        intent.putExtra("idUsuario",idUsuario);
                        intent.putExtra("idCata",idCata);
                        startActivity(intent);
                    } catch (MalformedURLException e) {
                        e.printStackTrace();
                    }
                }
            });
            builder.setNegativeButton(R.string.cancel, null);
            builder.show();
        }
    }
}