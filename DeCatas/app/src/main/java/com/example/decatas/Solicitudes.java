package com.example.decatas;

import android.graphics.Color;
import android.graphics.Typeface;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import java.net.MalformedURLException;
import java.util.LinkedHashMap;
import java.util.Map;

import javax.xml.parsers.FactoryConfigurationError;

public class Solicitudes extends AppCompatActivity {

    private String idUsuario;
    public TableLayout table;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_solicitudes);

        Bundle bundle = getIntent().getExtras();
        idUsuario = bundle.getString("id");

        table = (TableLayout)findViewById(R.id.table);

        this.update();
    }

    public void update(){
        table.removeAllViews();
        Map<String,String> params = new LinkedHashMap<>();
        params.put("id",idUsuario);
        try {
            Connection c = new Connection(getApplicationContext(),"getSolicitudes.php",params);
            while (c.getRes()==null);
            String result = c.getRes();
            if(result.equals("IOException")){
                Toast.makeText(this, R.string.error_connecting, Toast.LENGTH_SHORT).show();
            } else if(!result.equals("")){
                String[] requests = result.split(";");
                for(String r : requests){
                    String[] infoRequest = r.split(",");
                    String idRequest = infoRequest[0];
                    String nombreRequest = infoRequest[1];
                    String userRequest = infoRequest[2];

                    TableRow tr = new TableRow(this);

                    tr.setGravity(Gravity.CENTER);
                    tr.setBackgroundResource(R.drawable.tables);
                    tr.setPadding(10,10,10,10);

                    tr.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    tr.setVisibility(View.VISIBLE);

                    TextView tv = new TextView(this);
                    tv.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));
                    tv.setGravity(Gravity.CENTER);
                    tv.setVisibility(View.VISIBLE);
                    tv.setPadding(10,10,10,10);
                    tv.setTextSize(20);
                    tv.setText(nombreRequest+" ("+userRequest+")");

                    tr.addView(tv);

                    ImageButton btnAceptar = new ImageButton(this);
                    btnAceptar.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));
                    btnAceptar.setBackgroundColor(Color.GREEN);
                    btnAceptar.getLayoutParams().height=120;
                    btnAceptar.getLayoutParams().width=120;
                    btnAceptar.setPadding(10,10,10,10);
                    btnAceptar.setBackgroundResource(R.drawable.ic_accept_foreground);

                    Accept a = new Accept(idRequest,this.idUsuario);
                    btnAceptar.setOnClickListener(a);

                    tr.addView(btnAceptar);

                    ImageButton btnRechazar = new ImageButton(this);
                    btnRechazar.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));
                    btnRechazar.getLayoutParams().height=120;
                    btnRechazar.getLayoutParams().width=120;
                    btnRechazar.setBackgroundColor(Color.RED);
                    btnRechazar.setPadding(10,10,10,10);
                    btnRechazar.setBackgroundResource(R.drawable.ic_decline_foreground);

                    Decline d = new Decline(idRequest,this.idUsuario);
                    btnRechazar.setOnClickListener(d);

                    tr.addView(btnRechazar);

                    table.addView(tr);
                }
            }
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
    }

    private class Accept implements View.OnClickListener{

        String idUsuario1,idUsuario2;

        public Accept(String id1,String id2){
            this.idUsuario1=id1;
            this.idUsuario2=id2;
        }

        @Override
        public void onClick(View v) {
            Map<String,String> params = new LinkedHashMap<>();
            params.put("id1",idUsuario1);
            params.put("id2",idUsuario2);

            try {
                Connection c = new Connection(getApplicationContext(),"aceptar.php",params);
                while (c.getRes()==null);
                String result = c.getRes();
                if(result.equals("IOException")){
                    Toast.makeText(Solicitudes.this, R.string.error_connecting, Toast.LENGTH_SHORT).show();
                } if(result.equals("1")){
                    Toast.makeText(Solicitudes.this, R.string.request_accept, Toast.LENGTH_LONG).show();
                    update();
                }else {
                    Toast.makeText(Solicitudes.this, R.string.request_accept_error, Toast.LENGTH_LONG).show();
                }
            } catch (MalformedURLException e) {
                e.printStackTrace();
            }
        }
    }

    private class Decline implements View.OnClickListener{

        String idUsuario1,idUsuario2;

        public Decline(String id1,String id2){
            this.idUsuario1=id1;
            this.idUsuario2=id2;
        }

        @Override
        public void onClick(View v) {
            Map<String,String> params = new LinkedHashMap<>();
            params.put("id1",idUsuario1);
            params.put("id2",idUsuario2);

            try {
                Connection c = new Connection(getApplicationContext(),"rechazar.php",params);
                while (c.getRes()==null);
                String result = c.getRes();
                if(result.equals("IOException")){
                    Toast.makeText(Solicitudes.this, R.string.error_connecting, Toast.LENGTH_SHORT).show();
                } else if(result.equals("1")){
                    Toast.makeText(Solicitudes.this, R.string.request_decline, Toast.LENGTH_LONG).show();
                    update();
                }else {
                    Toast.makeText(Solicitudes.this, R.string.decline_request_error, Toast.LENGTH_LONG).show();
                }
            } catch (MalformedURLException e) {
                e.printStackTrace();
            }
        }
    }
}