package com.example.decatas;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import java.net.MalformedURLException;
import java.util.LinkedHashMap;
import java.util.Map;

public class Cata extends AppCompatActivity {

    private String idUsuario,idCata,nombreCata,idAdmin,nCervezas;
    public TextView title;
    public EditText editNuevaCerveza;
    public Button btn;
    public TableLayout table1;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cata);

        Bundle bundle = getIntent().getExtras();
        this.idUsuario = bundle.getString("idUsuario");
        this.idCata = bundle.getString("idCata");

        this.title = (TextView)findViewById(R.id.title);
        this.editNuevaCerveza = (EditText) findViewById(R.id.editTextTextBeerName);
        this.btn = (Button)findViewById(R.id.add);
        this.table1 = (TableLayout)findViewById(R.id.table1);

        Map<String,String> p = new LinkedHashMap<>();
        p.put("id",idCata);
        Connection con = null;
        try {
            con = new Connection(this,"getNCervezas.php",p);
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
        while(con.getRes()==null);
        this.nCervezas = con.getRes();

        Map<String,String> params = new LinkedHashMap<>();
        params.put("id",idCata);

        try {
            Connection conn = new Connection(this,"getCata.php",params);
            while(conn.getRes()==null);
            String result = conn.getRes();
            if(result.equals("0")){
                Toast.makeText(this,"No se pudo cargar la cata",Toast.LENGTH_LONG).show();
            }else {
                String[] res = result.split("/");
                String aux = res[0];
                Log.v("Cata",aux);
                String[] infoCata = aux.split(",");
                this.nombreCata = infoCata[0];
                this.idAdmin = infoCata[1];

                title.setText(nombreCata);

                if(idUsuario.equals(idAdmin)){
                    editNuevaCerveza.setVisibility(View.VISIBLE);
                    btn.setVisibility(View.VISIBLE);
                }else {
                    editNuevaCerveza.setVisibility(View.INVISIBLE);
                    btn.setVisibility(View.INVISIBLE);
                }

                table1.removeAllViews();

                TableRow trTH = new TableRow(this);

                trTH.setGravity(Gravity.CENTER);

                trTH.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT));

                trTH.setVisibility(View.VISIBLE);

                TextView tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10,10,10,10);
                tv.setTextSize(15);
                tv.setText(R.string.participants);

                trTH.addView(tv);

                table1.addView(trTH);

                aux = res[1];
                String[] infoPersonas = aux.split(";");

                for(int i=0;i<infoPersonas.length;i++){
                    String row = infoPersonas[i];
                    String[] infoPersona = row.split(",");

                    String nombre = infoPersona[0];
                    String usuario = infoPersona[1];
                    String nC = infoPersona[2];

                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);

                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10,10,10,10);
                    tv1.setTextSize(15);
                    tv1.setVisibility(View.VISIBLE);
                    String text = nombre+"("+usuario+"): "+nC+"/"+nCervezas+" valoraciones";
                    tv1.setText(text);
                    trTD.addView(tv1);

                    table1.addView(trTD);
                }

                trTH = new TableRow(this);

                trTH.setGravity(Gravity.CENTER);

                trTH.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT));

                trTH.setVisibility(View.VISIBLE);

                tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10,20,10,10);
                tv.setTextSize(15);
                tv.setText(R.string.beers);

                trTH.addView(tv);

                table1.addView(trTH);

                if(res.length>2){
                    aux = res[2];
                    String[] infoCervezas = aux.split(";");

                    for(int i=0;i<infoCervezas.length;i++){
                        String cad = infoCervezas[i];

                        String cerveza[] = cad.split(",");

                        final String idCerveza = cerveza[0];
                        String nombre = cerveza[1];

                        TableRow trTD = new TableRow(this);

                        trTD.setGravity(Gravity.CENTER);

                        trTD.setLayoutParams(new TableRow.LayoutParams(
                                TableRow.LayoutParams.FILL_PARENT,
                                TableRow.LayoutParams.WRAP_CONTENT));

                        trTD.setVisibility(View.VISIBLE);

                        TextView tv1 = new TextView(this);

                        tv1.setLayoutParams(new TableRow.LayoutParams(
                                TableRow.LayoutParams.FILL_PARENT,
                                TableRow.LayoutParams.WRAP_CONTENT
                        ));

                        tv1.setGravity(Gravity.CENTER);
                        tv1.setPadding(10,10,10,10);
                        tv1.setTextSize(15);
                        tv1.setVisibility(View.VISIBLE);
                        tv1.setText(nombre);

                        tv1.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                Intent intent = new Intent(getApplicationContext(),Valorar_Cerveza.class);
                                intent.putExtra("id", idUsuario);
                                intent.putExtra("c",idCerveza);
                                intent.putExtra("ca",idCata);
                                startActivity(intent);
                            }
                        });

                        trTD.addView(tv1);

                        table1.addView(trTD);
                    }
                } else {
                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);

                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView tv1 = new TextView(this);

                    tv1.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));

                    tv1.setGravity(Gravity.CENTER);
                    tv1.setPadding(10,10,10,10);
                    tv1.setTextSize(15);
                    tv1.setVisibility(View.VISIBLE);
                    tv1.setText(R.string.no_beers);
                    trTD.addView(tv1);

                    table1.addView(trTD);
                }

            }
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
    }

    public void add(View v) throws MalformedURLException {
        editNuevaCerveza.setBackgroundResource(R.drawable.input_normal);

        String beerName = editNuevaCerveza.getText().toString();

        if(!beerName.equals("")){
            Map<String,String> params = new LinkedHashMap<>();
            params.put("n",beerName);
            params.put("id",idCata);
            Connection con = new Connection(this,"createCerveza.php",params);
            while(con.getRes()==null);
            String result = con.getRes();
            if(result.equals("1")){
                update(v);
            } else {
                Toast.makeText(this, "No se ha podido añadir la cerveza", Toast.LENGTH_LONG).show();
            }
        } else {
            Toast.makeText(this, "Introduce el nombre de una cerveza", Toast.LENGTH_LONG).show();
            editNuevaCerveza.setBackgroundResource(R.drawable.input_error);
        }


    }

    public void update(View view){
        finish();
        startActivity(getIntent());
    }

    @Override
    public void onBackPressed() {
        AlertDialog.Builder b = new AlertDialog.Builder(this);
        b.setIcon(android.R.drawable.ic_dialog_alert);
        b.setTitle("Salir...");
        b.setCancelable(false);
        b.setMessage("¿Está seguro que quiere salir de la cata? Puedes volver en cualquier momento si sigue en curso");
        b.setPositiveButton("Sí", new DialogInterface.OnClickListener(){
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    dialog.dismiss();
                    Intent intent = new Intent(getApplicationContext(),User.class);
                    intent.putExtra("id",idUsuario);
                    startActivity(intent);
                }
            });
        b.setNegativeButton("No", null);
        AlertDialog alert = b.create();
        alert.show();
    }
}